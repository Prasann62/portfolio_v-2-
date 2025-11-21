<?php
header('Content-Type: application/json');
$json = file_get_contents("https://fantasy.premierleague.com/api/fixtures/");
if (!$json) { echo json_encode(["error" => "Failed to fetch fixtures"]); exit; }

$data = json_decode($json, true);
$fixtures = [];

foreach ($data as $f) {
    $fixtures[] = [
        "event" => $f['event'],
        "team_h" => $f['team_h'],
        "team_a" => $f['team_a'],
        "team_h_difficulty" => $f['team_h_difficulty'],
        "team_a_difficulty" => $f['team_a_difficulty'],
        "kickoff_time" => $f['kickoff_time']
    ];
}
echo json_encode($fixtures);
?>