<?php
include 'db.php';

$json = file_get_contents("https://fantasy.premierleague.com/api/bootstrap-static/");
$data = json_decode($json, true);

$res = $conn->query("SELECT * FROM user_teams");
while ($row = $res->fetch_assoc()) {
    $uid = $row['user_id'];
    $pid = $row['player_id'];

    foreach ($data['elements'] as $p) {
        if ($p['id'] == $pid && in_array($p['status'], ['i','d','s'])) {
            $msg = $p['web_name']." is ".$p['news'];
            $type = $p['status']=='i' ? "danger" : "warning";

            // avoid duplicate alerts
            $check = $conn->prepare("SELECT id FROM notifications WHERE user_id=? AND message=?");
            $check->bind_param("is", $uid, $msg);
            $check->execute();
            $checkRes = $check->get_result();
            if ($checkRes->num_rows == 0) {
                $stmt = $conn->prepare("INSERT INTO notifications (user_id, message, type) VALUES (?,?,?)");
                $stmt->bind_param("iss", $uid, $msg, $type);
                $stmt->execute();
            }
        }
    }
}
?>