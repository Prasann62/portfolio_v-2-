[file name]: transfer.php
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

if (!$input || !isset($input['out']) || !isset($input['in'])) {
    echo json_encode(["error" => "Invalid input"]);
    exit();
}

$out_player = $input['out'];
$in_player = $input['in'];

// First check if out player exists in user's team
$check_sql = "SELECT * FROM user_teams WHERE user_id = ? AND player_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $user_id, $out_player);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows === 0) {
    echo json_encode(["error" => "Player not in your team"]);
    exit();
}

$out_player_data = $check_result->fetch_assoc();
$check_stmt->close();

// Get info about the incoming player
$player_sql = "SELECT web_name as name, element_type as position, now_cost/10 as cost 
               FROM players WHERE id = ?";
$player_stmt = $conn->prepare($player_sql);
$player_stmt->bind_param("i", $in_player);
$player_stmt->execute();
$player_result = $player_stmt->get_result();

if ($player_result->num_rows === 0) {
    echo json_encode(["error" => "Invalid player ID"]);
    exit();
}

$in_player_data = $player_result->fetch_assoc();
$player_stmt->close();

// Update the team - replace out player with in player
$update_sql = "UPDATE user_teams 
               SET player_id = ?, player_name = ?, position = ?, cost = ?
               WHERE user_id = ? AND player_id = ?";
$update_stmt = $conn->prepare($update_sql);
$update_stmt->bind_param(
    "isidii", 
    $in_player, 
    $in_player_data['name'], 
    $in_player_data['position'], 
    $in_player_data['cost'],
    $user_id,
    $out_player
);

if ($update_stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["error" => "Transfer failed"]);
}

$update_stmt->close();
$conn->close();
?>
[file content end]