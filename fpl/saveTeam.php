[file name]: saveTeam.php
[file content begin]
<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit();
}

$user_id = $_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['players']) || !isset($input['captain']) || !isset($input['vice'])) {
    echo json_encode(["error" => "Invalid input"]);
    exit();
}

$players = $input['players'];
$captain = $input['captain'];
$vice = $input['vice'];

// First delete existing team for this user
$delete_sql = "DELETE FROM user_teams WHERE user_id = ?";
$delete_stmt = $conn->prepare($delete_sql);
$delete_stmt->bind_param("i", $user_id);
$delete_stmt->execute();
$delete_stmt->close();

// Insert new team
$sql = "INSERT INTO user_teams (user_id, player_id, player_name, position, cost, is_captain, is_vice) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

foreach ($players as $index => $player) {
    $is_captain = ($player['id'] == $captain) ? 1 : 0;
    $is_vice = ($player['id'] == $vice) ? 1 : 0;
    
    $stmt->bind_param(
        "iisidii", 
        $user_id, 
        $player['id'], 
        $player['name'], 
        $player['position'], 
        $player['cost'],
        $is_captain,
        $is_vice
    );
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo json_encode(["success" => true]);
?>
[file content end]