<?php
include 'db.php';

$gw = isset($_GET['gw']) ? intval($_GET['gw']) : 1;

// Get all users
$users = $conn->query("SELECT id FROM users");

if (!$users) {
    echo json_encode(["error" => "Failed to fetch users: " . $conn->error]);
    exit;
}

while ($u = $users->fetch_assoc()) {
    $user_id = $u['id'];

    // Get user team
    $teamRes = $conn->query("SELECT * FROM user_teams WHERE user_id=$user_id");
    if (!$teamRes) {
        echo "Error fetching team for user $user_id: " . $conn->error . "<br>";
        continue;
    }
    
    $team = [];
    while ($row = $teamRes->fetch_assoc()) {
        $team[] = $row;
    }

    $totalPoints = 0;

    foreach ($team as $pick) {
        $pid = $pick['player_id'];
        $json = @file_get_contents("https://fantasy.premierleague.com/api/element-summary/$pid/");
        if (!$json) continue;
        
        $data = json_decode($json, true);
        if (!$data || !isset($data['history'])) continue;

        foreach ($data['history'] as $match) {
            if ($match['round'] == $gw) {
                $points = $match['total_points'];
                if ($pick['is_captain'] == 1) $points *= 2;
                $totalPoints += $points;
                break; // Found the gameweek, move to next player
            }
        }
    }

    // Save / update points
    $sql = "INSERT INTO user_points (user_id, gameweek, points) 
            VALUES (?, ?, ?)
            ON DUPLICATE KEY UPDATE points=?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "Error preparing statement for user $user_id: " . $conn->error . "<br>";
        continue;
    }
    
    $stmt->bind_param("iiii", $user_id, $gw, $totalPoints, $totalPoints);
    if (!$stmt->execute()) {
        echo "Error executing statement for user $user_id: " . $stmt->error . "<br>";
    }
}

echo "League updated for GW $gw";
?>