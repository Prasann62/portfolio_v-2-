<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["error" => "Not logged in"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM user_teams WHERE user_id = ? ORDER BY slot";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$team = [];
while ($row = $result->fetch_assoc()) {
    $team[] = $row;
}

echo json_encode($team);
?>