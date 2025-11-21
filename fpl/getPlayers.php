<?php
header('Content-Type: application/json');

// FPL bootstrap API (contains all players, teams, events)
$url = "https://fantasy.premierleague.com/api/bootstrap-static/";

// Fetch data
$data = file_get_contents($url);

// Return JSON to frontend
if ($data) {
    echo $data;
} else {
    echo json_encode(["error" => "Failed to fetch FPL data"]);
}
?>
