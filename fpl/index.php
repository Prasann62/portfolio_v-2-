<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>FPL Champ - All in One</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    body { background: #f8f9fa; }
    .navbar { background: #004d00; }
    .navbar-brand, .nav-link { color: #fff !important; }
    section { display: none; padding: 2rem 0; }
    section.active { display: block; }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="#">FPL Champ</a>
    <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon bg-light"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item"><a class="nav-link nav-btn" data-target="home">Home</a></li>
        <li class="nav-item"><a class="nav-link nav-btn" data-target="dashboard">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link nav-btn" data-target="players">Players</a></li>
        <li class="nav-item"><a class="nav-link nav-btn" data-target="fixtures">Fixtures</a></li>
        <li class="nav-item"><a class="nav-link nav-btn" data-target="league">League</a></li>
        <li class="nav-item"><a class="nav-link nav-btn" data-target="overall">Overall</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container">

  <!-- HOME -->
  <section id="home" class="active">
    <h2>Welcome to FPL Champ</h2>
    <p>This is your all-in-one Fantasy Premier League dashboard 🚀</p>
  </section>

  <!-- DASHBOARD -->
  <section id="dashboard">
    <h2>Dashboard</h2>
    <div id="notifications"></div>
    <div id="dashboardContent"></div>
  </section>

  <!-- PLAYERS -->
  <section id="players">
    <h2>Player Statistics</h2>
    <div class="row mb-3">
      <div class="col-md-4"><input id="searchBox" class="form-control" placeholder="Search player..."></div>
      <div class="col-md-4"><select id="positionFilter" class="form-select"><option value="">All</option><option value="1">GK</option><option value="2">DEF</option><option value="3">MID</option><option value="4">FWD</option></select></div>
      <div class="col-md-4"><select id="teamFilter" class="form-select"><option value="">All Teams</option></select></div>
    </div>
    <table class="table table-striped text-center">
      <thead><tr><th>Name</th><th>Pos</th><th>Price</th><th>Form</th><th>Points</th><th>Status</th></tr></thead>
      <tbody id="playerTable"></tbody>
    </table>
  </section>

  <!-- FIXTURES -->
  <section id="fixtures">
    <h2>Upcoming Fixtures</h2>
    <ul id="fixturesList" class="list-group"></ul>
    <h4 class="mt-4">Fixture Difficulty Rating (FDR)</h4>
    <select id="teamSelect" class="form-select w-25 mb-3"></select>
    <canvas id="fdrChart" height="120"></canvas>
  </section>

  <!-- LEAGUE -->
  <section id="league">
    <h2>League Standings</h2>
    <div id="leagueStandings"></div>
  </section>

  <!-- OVERALL -->
  <section id="overall">
    <h2>Overall Rankings</h2>
    <div id="overallContent"></div>
  </section>

</div>

<footer class="text-center bg-dark text-light py-3 mt-4">
  <p>© 2025 FPL Champ</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // SPA Navigation
  document.querySelectorAll(".nav-btn").forEach(btn=>{
    btn.addEventListener("click", ()=>{
      document.querySelectorAll("section").forEach(sec=>sec.classList.remove("active"));
      document.getElementById(btn.dataset.target).classList.add("active");
    });
  });

  // Load data when section is opened
  document.querySelector('[data-target="players"]').addEventListener("click", loadPlayers);
  document.querySelector('[data-target="fixtures"]').addEventListener("click", ()=>{loadFixtures(); populateTeamDropdown();});
  document.querySelector('[data-target="league"]').addEventListener("click", loadLeague);

  async function loadPlayers(){
    const res = await fetch("getPlayers.php"); const data = await res.json();
    const tbody = document.getElementById("playerTable"); tbody.innerHTML="";
    const positions={1:"GK",2:"DEF",3:"MID",4:"FWD"};
    data.elements.slice(0,30).forEach(p=>{
      let status = (p.status=="i")?`<span class='badge bg-danger'>Injured</span>`:(p.status=="d")?`<span class='badge bg-warning'>Doubtful</span>`:`<span class='badge bg-success'>Fit</span>`;
      tbody.innerHTML += `<tr><td>${p.web_name}</td><td>${positions[p.element_type]}</td><td>£${(p.now_cost/10).toFixed(1)}m</td><td>${p.form}</td><td>${p.total_points}</td><td>${status}</td></tr>`;
    });
  }

  async function loadFixtures(){
    const res = await fetch("getFixtures.php"); const data = await res.json();
    const list=document.getElementById("fixturesList"); list.innerHTML="";
    data.slice(0,10).forEach(f=>list.innerHTML+=`<li class="list-group-item">GW${f.event} — Team ${f.team_h} vs Team ${f.team_a}</li>`);
  }

  async function populateTeamDropdown(){
    const res=await fetch("getPlayers.php"); const data=await res.json();
    const sel=document.getElementById("teamSelect"); sel.innerHTML="";
    data.teams.forEach(t=>{let opt=document.createElement("option"); opt.value=t.id; opt.textContent=t.name; sel.appendChild(opt);});
  }

  async function loadLeague(){
    const res=await fetch("getLeague.php"); const data=await res.json();
    const c=document.getElementById("leagueStandings"); c.innerHTML="";
    data.forEach((t,i)=>c.innerHTML+=`<div>${i+1}. ${t.name} — ${t.points}</div>`);
  }
</script>
</body>
</html>
