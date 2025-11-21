<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) { echo "[]"; exit; }

$user_id = $_SESSION['user_id'];

$sql = "SELECT gw, SUM(points) as points FROM user_points 
        WHERE user_id=? GROUP BY gw ORDER BY gw ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();

$data = [];
while($row=$res->fetch_assoc()) $data[]=$row;

echo json_encode($data);
?>
