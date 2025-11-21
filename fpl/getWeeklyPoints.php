<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$gw = isset($_GET['gw']) ? intval($_GET['gw']) : 1;
$user_id = $_SESSION['user_id'];

// Get saved team with slot information
$sql = "SELECT * FROM user_teams WHERE user_id = ? ORDER BY slot";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$team = [];
while ($row = $result->fetch_assoc()) {
    $team[] = $row;
}

// Get all player data for position checking
$allPlayersJson = file_get_contents("https://fantasy.premierleague.com/api/bootstrap-static/");
$allPlayersData = json_decode($allPlayersJson, true);
$allPlayers = [];
foreach ($allPlayersData['elements'] as $player) {
    $allPlayers[$player['id']] = $player;
}

// Separate starters (slots 1-11) and bench (slots 12-15)
$starters = array_filter($team, function($p) { return $p['slot'] <= 11; });
$bench = array_filter($team, function($p) { return $p['slot'] > 11; });

// Sort bench by slot (sub order)
usort($bench, function($a, $b) { return $a['slot'] - $b['slot']; });

// Initialize variables
$captainId = null;
$viceId = null;
$pointsMap = [];
$usedBenchPlayers = [];

// First pass - get points for all players
foreach ($team as $pick) {
    $pid = $pick['player_id'];
    $json = @file_get_contents("https://fantasy.premierleague.com/api/element-summary/$pid/");
    if (!$json) continue;

    $data = json_decode($json, true);
    if (!isset($data['history'])) continue;

    $gwPoints = 0;
    $minutes = 0;
    foreach ($data['history'] as $match) {
        if ($match['round'] == $gw) {
            $gwPoints = $match['total_points'];
            $minutes = $match['minutes'];
            break;
        }
    }

    $pointsMap[$pid] = [
        "points" => $gwPoints,
        "minutes" => $minutes,
        "is_captain" => $pick['is_captain'],
        "is_vice" => $pick['is_vice_captain'],
        "position" => $allPlayers[$pid]['element_type'] ?? 0,
        "slot" => $pick['slot']
    ];

    if ($pick['is_captain']) {
        $captainId = $pid;
    }
    if ($pick['is_vice_captain']) {
        $viceId = $pid;
    }
}

// Process auto-substitutions
$finalTeam = [];
foreach ($starters as $starter) {
    $pid = $starter['player_id'];
    $playerData = $pointsMap[$pid];
    
    // If starter didn't play (0 minutes), try to substitute
    if ($playerData['minutes'] == 0) {
        $substituted = false;
        
        // Look for a substitute with the same position
        foreach ($bench as $sub) {
            $subPid = $sub['player_id'];
            
            // Skip if already used or doesn't match position
            if (in_array($subPid, $usedBenchPlayers) || 
                !isset($pointsMap[$subPid]) ||
                $pointsMap[$subPid]['position'] != $playerData['position']) {
                continue;
            }
            
            // Use this substitute
            $substituted = true;
            $usedBenchPlayers[] = $subPid;
            $finalTeam[] = [
                "player_id" => $subPid,
                "points" => $pointsMap[$subPid]['points'],
                "is_captain" => $playerData['is_captain'], // Keep captain status
                "is_vice" => $playerData['is_vice'], // Keep vice status
                "was_sub" => true,
                "original_player" => $pid
            ];
            break;
        }
        
        // If no substitution was made, keep the original player with 0 points
        if (!$substituted) {
            $finalTeam[] = [
                "player_id" => $pid,
                "points" => 0,
                "is_captain" => $playerData['is_captain'],
                "is_vice" => $playerData['is_vice'],
                "was_sub" => false
            ];
        }
    } else {
        // Starter played, include normally
        $finalTeam[] = [
            "player_id" => $pid,
            "points" => $playerData['points'],
            "is_captain" => $playerData['is_captain'],
            "is_vice" => $playerData['is_vice'],
            "was_sub" => false
        ];
    }
}

// Apply captain/vice rules
$captainPlayed = false;
$totalPoints = 0;

// First, check if captain played
foreach ($finalTeam as &$player) {
    if ($player['is_captain'] && $player['points'] > 0) {
        $captainPlayed = true;
        break;
    }
}

// Then apply points with captain/vice rules
foreach ($finalTeam as &$player) {
    $points = $player['points'];
    
    if ($player['is_captain']) {
        if ($captainPlayed) {
            $points *= 2;
        } elseif ($viceId) {
            // Captain didn't play, check if vice did
            $vicePlayed = false;
            foreach ($finalTeam as $p) {
                if ($p['player_id'] == $viceId && $p['points'] > 0) {
                    $vicePlayed = true;
                    break;
                }
            }
            
            if ($vicePlayed) {
                $points = 0; // Captain gets 0, vice will get double
            }
        }
    } elseif ($player['is_vice'] && !$captainPlayed && $player['points'] > 0) {
        // Vice becomes captain if captain didn't play
        $points *= 2;
    }
    
    $player['final_points'] = $points;
    $totalPoints += $points;
}

echo json_encode([
    "gameweek" => $gw,
    "total_points" => $totalPoints,
    "players" => $finalTeam,
    "used_subs" => $usedBenchPlayers
]);
?>