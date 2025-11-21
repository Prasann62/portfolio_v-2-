<?php
include 'db.php';

$sql = "SELECT u.name, SUM(p.points) as total_points
        FROM user_points p
        JOIN users u ON p.user_id = u.id
        GROUP BY u.id
        ORDER BY total_points DESC";

$res = $conn->query($sql);
$data = [];
while($row=$res->fetch_assoc()) $data[]=$row;

echo json_encode($data);
?>