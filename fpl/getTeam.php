<?php
header('Content-Type: application/json');

// Replace with your FPL team ID and current GW
$team_id = 1234567;   // <-- put your team ID here
$gw = 5;              // <-- put current GW here

$url = "https://fantasy.premierleague.com/api/entry/$team_id/event/$gw/picks/";

// Fetch
$data = @file_get_contents($url);

if ($data) {
    echo $data;
} else {
    echo json_encode(["error" => "Failed to fetch team data"]);
}
?>
