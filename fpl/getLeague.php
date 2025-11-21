<?php
include 'db.php';
$gw = isset($_GET['gw']) ? intval($_GET['gw']) : 1;

$sql = "SELECT u.name, SUM(p.points) as points
        FROM user_points p
        JOIN users u ON p.user_id = u.id
        WHERE p.gw=?
        GROUP BY u.id
        ORDER BY points DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $gw);
$stmt->execute();
$res = $stmt->get_result();

$data = [];
while($row=$res->fetch_assoc()) $data[]=$row;
echo json_encode($data);
?>