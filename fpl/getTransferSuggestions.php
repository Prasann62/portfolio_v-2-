<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
  echo json_encode(["error" => "Not logged in"]);
  exit;
}
$user_id = $_SESSION['user_id'];

// Get user team
$sql = "SELECT * FROM user_teams WHERE user_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$team = [];
while($row=$res->fetch_assoc()) $team[]=$row;

// Get players data
$json = file_get_contents("https://fantasy.premierleague.com/api/bootstrap-static/");
$data = json_decode($json, true);
$players = $data['elements'];
$teams = [];
foreach ($data['teams'] as $t) $teams[$t['id']] = $t['name'];

// Build lookup
$map = [];
foreach ($players as $p) $map[$p['id']] = $p;

// Find weakest player (lowest form/points)
$weakest = null;
foreach ($team as $pick) {
  $p = $map[$pick['player_id']];
  if (!$weakest || $p['form'] < $weakest['form']) {
    $weakest = $p;
  }
}

// Find best replacement (same position, similar price)
$budget = $weakest['now_cost']; // max price = player’s current cost
$best = null;
foreach ($players as $p) {
  if ($p['element_type'] == $weakest['element_type'] && $p['now_cost'] <= $budget) {
    // Score = form * total_points
    $score = floatval($p['form']) * $p['total_points'];
    if (!$best || $score > $best['score']) {
      $best = [
        "id" => $p['id'],
        "name" => $p['web_name'],
        "team" => $teams[$p['team']],
        "price" => $p['now_cost']/10,
        "form" => $p['form'],
        "points" => $p['total_points'],
        "score" => $score
      ];
    }
  }
}

echo json_encode([
  "out" => [
    "id" => $weakest['id'],
    "name" => $weakest['web_name'],
    "team" => $teams[$weakest['team']],
    "price" => $weakest['now_cost']/10,
    "form" => $weakest['form'],
    "points" => $weakest['total_points']
  ],
  "in" => $best
]);
?>
