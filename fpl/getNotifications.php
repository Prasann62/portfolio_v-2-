<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) { echo "[]"; exit; }
$uid = $_SESSION['user_id'];

$sql = "SELECT * FROM notifications WHERE user_id=? ORDER BY created_at DESC LIMIT 20";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$res = $stmt->get_result();

$data = [];
while($row=$res->fetch_assoc()) $data[]=$row;
echo json_encode($data);
?>