
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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FPL Champ - Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <style>
    body { background-color: #f8f9fa; }
    .navbar { background-color: #004d00; }
    .navbar-brand, .nav-link { color: #fff !important; font-weight: 500; }
    .card img { height: 150px; object-fit: cover; }
    footer { background: #004d00; color: #fff; padding: 20px 0; }
    footer a { color: #fff; margin: 0 10px; }
    .pitch { 
      background-color: #4CAF50; 
      padding: 20px; 
      border-radius: 10px; 
      position: relative;
      margin-bottom: 20px;
    }
    .row-position {
      display: flex;
      justify-content: space-around;
      margin: 15px 0;
      min-height: 100px;
    }
    .player-card {
      background: rgba(255, 255, 255, 0.9);
      padding: 10px;
      border-radius: 5px;
      width: 100px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.html">FPL Champ</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon bg-light"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
          <li class="nav-item"><a class="nav-link active" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="players.html">Players</a></li>
          <li class="nav-item"><a class="nav-link" href="fixtures.html">Fixtures</a></li>
          <li class="nav-item"><a class="nav-link" href="league.html">League</a></li>
          <li class="nav-item"><a class="nav-link" href="overall.html">Overall</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container my-5">
    <h4 class="mb-3">Notifications</h4>
    <div id="notifications" class="mb-3"></div>
  
    <!-- Plan My Team Section -->
    <h4 class="mb-3">Plan My Team</h4>
    <div class="alert alert-info">
      <strong>Instructions:</strong> Select 15 players (11 starters + 4 bench). 
      The first 11 players will be your starting lineup, the next 4 will be your bench in order.
    </div>
    <form id="teamForm">
      <div class="row" id="playerSelect"></div>
      <div class="mt-3">
        <h5>Selected Players: <span id="selectedCount">0</span>/15</h5>
        <div id="selectedPlayers" class="mb-3"></div>
        <label>Captain ID:</label>
        <input type="number" name="captain" id="captain" class="form-control mb-2">
        <label>Vice-Captain ID:</label>
        <input type="number" name="vice" id="vice" class="form-control mb-2">
        <button type="submit" class="btn btn-success">Save Team</button>
      </div>
    </form>

    <!-- My Saved Team Section -->
    <h4 class="mt-5 mb-3">My Saved Team</h4>
    <div id="savedTeam" class="row g-3"></div>

    <!-- Team Preview Section -->
    <h4 class="mt-5 mb-3">Team Preview</h4>
    <div class="pitch">
      <div id="gkRow" class="row-position"></div>
      <div id="defRow" class="row-position"></div>
      <div id="midRow" class="row-position"></div>
      <div id="fwdRow" class="row-position"></div>
    </div>

    <!-- Make a Transfer Section -->
    <h4 class="mt-5 mb-3">Make a Transfer</h4>
    <form id="transferForm" class="row g-3">
      <div class="col-md-5">
        <label>Out Player (ID)</label>
        <input type="number" id="outPlayer" name="out" class="form-control" required>
      </div>
      <div class="col-md-5">
        <label>In Player (ID)</label>
        <input type="number" id="inPlayer" name="in" class="form-control" required>
      </div>
      <div class="col-md-2 d-flex align-items-end">
        <button type="submit" class="btn btn-danger w-100">Transfer</button>
      </div>
    </form>

    <!-- Weekly Points Section -->
    <h4 class="mt-5 mb-3">Weekly Points</h4>
    <div class="d-flex mb-3">
      <input type="number" id="gwInput" class="form-control w-25 me-2" placeholder="Gameweek #" value="1" min="1" max="38">
      <button class="btn btn-primary" onclick="loadWeeklyPoints()">Load Points</button>
    </div>
    <div class="container my-5">
      <h4 class="text-center mb-4">My Weekly Points Trend</h4>
      <canvas id="weeklyPointsChart" height="120"></canvas>
    </div>
    <div id="weeklyPoints" class="alert alert-info">Enter a Gameweek to see points</div>
    
    <!-- League Standings Section -->
    <h4 class="mt-5 mb-3">League Standings</h4>
    <div class="d-flex mb-3">
      <input type="number" id="leagueGwInput" class="form-control w-25 me-2" placeholder="Gameweek #" value="1" min="1" max="38">
      <button class="btn btn-primary" onclick="loadLeagueStandings()">Load Standings</button>
    </div>
    <div id="leagueStandings" class="alert alert-info">Enter a Gameweek to see league standings</div>

    <div class="text-center mt-3">
      <a href="league.html" class="btn btn-outline-primary">View Full League Table</a>
    </div>

    <!-- Upcoming Fixtures Section -->
    <h4 class="mt-5 mb-3">Upcoming Fixtures</h4>
    <ul id="fixturesList" class="list-group"></ul>

    <h4 class="mt-5 mb-3">Fixture Difficulty Rating (Next 5 GWs)</h4>
    <select id="teamSelect" class="form-select w-25 mb-3"></select>
    <canvas id="fdrChart" height="120"></canvas>

    <h4 class="mt-5 mb-3">AI Transfer Suggestions</h4>
    <div id="transferSuggestions" class="alert alert-info">Loading suggestions...</div>
  </div>

  <!-- Footer -->
  <footer class="text-center">
    <p>© 2025 FPL Champ | All Rights Reserved</p>
    <div>
      <a href="#"><i class="bi bi-facebook"></i></a>
      <a href="#"><i class="bi bi-twitter"></i></a>
      <a href="#"><i class="bi bi-instagram"></i></a>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Plan My Team functionality
    let selectedPlayers = [];
    
    async function loadPlayerOptions() {
      try {
        const res = await fetch("getPlayers.php");
        if (!res.ok) throw new Error("Failed to fetch players");
        
        const data = await res.json();
        const container = document.getElementById("playerSelect");
        container.innerHTML = "";

        if (!data.elements) throw new Error("No player data available");
        
        data.elements.slice(0, 50).forEach(p => {
          const positions = {1:"GK",2:"DEF",3:"MID",4:"FWD"};
          const pos = positions[p.element_type];
          
          container.innerHTML += `
            <div class="col-md-3 mb-2">
              <div class="card">
                <div class="card-body">
                  <h6>${p.web_name}</h6>
                  <p class="mb-1">${pos} | £${(p.now_cost/10).toFixed(1)}m</p>
                  <p class="mb-1">Points: ${p.total_points}</p>
                  <button type="button" class="btn btn-sm btn-outline-primary" onclick="addPlayer(${p.id}, '${p.web_name}', ${p.element_type}, ${p.now_cost/10})">
                    Add to Team
                  </button>
                </div>
              </div>
            </div>
          `;
        });
      } catch (error) {
        console.error("Error loading players:", error);
        document.getElementById("playerSelect").innerHTML = 
          `<div class="alert alert-danger">Failed to load players: ${error.message}</div>`;
      }
    }

    function addPlayer(id, name, position, cost) {
      if (selectedPlayers.length >= 15) {
        alert("You can only select 15 players total (11 starters + 4 bench)");
        return;
      }
      
      // Check if player is already selected
      if (selectedPlayers.some(p => p.id === id)) {
        alert("This player is already in your team");
        return;
      }
      
      selectedPlayers.push({id, name, position, cost});
      updateSelectedPlayers();
    }
    
    function removePlayer(index) {
      selectedPlayers.splice(index, 1);
      updateSelectedPlayers();
    }
    
    function updateSelectedPlayers() {
      const container = document.getElementById("selectedPlayers");
      const count = document.getElementById("selectedCount");
      
      count.textContent = selectedPlayers.length;
      container.innerHTML = "";
      
      selectedPlayers.forEach((player, index) => {
        const positions = {1:"GK",2:"DEF",3:"MID",4:"FWD"};
        container.innerHTML += `
          <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
            <div>
              ${player.name} (${positions[player.position]}) - £${player.cost.toFixed(1)}m
            </div>
            <button type="button" class="btn btn-sm btn-danger" onclick="removePlayer(${index})">Remove</button>
          </div>
        `;
      });
    }
    
    document.getElementById("teamForm").addEventListener("submit", async function(e) {
      e.preventDefault();
      
      if (selectedPlayers.length !== 15) {
        alert("Please select exactly 15 players (11 starters + 4 bench)");
        return;
      }
      
      const captain = document.getElementById("captain").value;
      const vice = document.getElementById("vice").value;
      
      if (!captain || !vice) {
        alert("Please select both captain and vice-captain");
        return;
      }
      
      if (!selectedPlayers.some(p => p.id == captain)) {
        alert("Captain must be one of your selected players");
        return;
      }
      
      if (!selectedPlayers.some(p => p.id == vice)) {
        alert("Vice-captain must be one of your selected players");
        return;
      }
      
      try {
        const res = await fetch("saveTeam.php", {
          method: "POST",
          headers: {"Content-Type": "application/json"},
          body: JSON.stringify({
            players: selectedPlayers,
            captain: parseInt(captain),
            vice: parseInt(vice)
          })
        });
        
        if (res.ok) {
          alert("Team saved successfully!");
          loadSavedTeam();
        } else {
          alert("Failed to save team");
        }
      } catch (error) {
        console.error("Error saving team:", error);
        alert("Failed to save team");
      }
    });

    // Load saved team
    async function loadSavedTeam() {
      try {
        const res = await fetch("getTeam.php");
        if (!res.ok) throw new Error("Failed to fetch team");
        
        const data = await res.json();
        const container = document.getElementById("savedTeam");
        container.innerHTML = "";
        
        if (data.error) {
          container.innerHTML = `<div class="alert alert-info">${data.error}</div>`;
          return;
        }
        
        data.players.forEach(player => {
          const positions = {1:"GK",2:"DEF",3:"MID",4:"FWD"};
          const pos = positions[player.position];
          
          container.innerHTML += `
            <div class="col-md-3 mb-3">
              <div class="card">
                <div class="card-body">
                  <h6>${player.name}</h6>
                  <p class="mb-1">${pos} | £${player.cost.toFixed(1)}m</p>
                  <p class="mb-1">ID: ${player.id}</p>
                  ${player.id == data.captain ? '<span class="badge bg-warning">Captain</span>' : ''}
                  ${player.id == data.vice ? '<span class="badge bg-info">Vice</span>' : ''}
                </div>
              </div>
            </div>
          `;
        });
        
        // Update team preview
        updateTeamPreview(data.players);
      } catch (error) {
        console.error("Error loading team:", error);
        document.getElementById("savedTeam").innerHTML = 
          `<div class="alert alert-danger">Failed to load team: ${error.message}</div>`;
      }
    }
    
    function updateTeamPreview(players) {
      const positions = {1:"GK",2:"DEF",3:"MID",4:"FWD"};
      const gkRow = document.getElementById("gkRow");
      const defRow = document.getElementById("defRow");
      const midRow = document.getElementById("midRow");
      const fwdRow = document.getElementById("fwdRow");
      
      gkRow.innerHTML = "";
      defRow.innerHTML = "";
      midRow.innerHTML = "";
      fwdRow.innerHTML = "";
      
      players.slice(0, 11).forEach(player => {
        const card = `
          <div class="player-card">
            <div class="fw-bold">${player.name}</div>
            <div>${positions[player.position]}</div>
          </div>
        `;
        
        switch(player.position) {
          case 1: gkRow.innerHTML += card; break;
          case 2: defRow.innerHTML += card; break;
          case 3: midRow.innerHTML += card; break;
          case 4: fwdRow.innerHTML += card; break;
        }
      });
    }

    // Transfer functionality
    document.getElementById("transferForm").addEventListener("submit", async function(e) {
      e.preventDefault();
      
      const outPlayer = document.getElementById("outPlayer").value;
      const inPlayer = document.getElementById("inPlayer").value;
      
      if (!outPlayer || !inPlayer) {
        alert("Please enter both out and in player IDs");
        return;
      }
      
      try {
        const res = await fetch("transfer.php", {
          method: "POST",
          headers: {"Content-Type": "application/json"},
          body: JSON.stringify({
            out: parseInt(outPlayer),
            in: parseInt(inPlayer)
          })
        });
        
        if (res.ok) {
          alert("Transfer successful!");
          loadSavedTeam();
        } else {
          alert("Transfer failed");
        }
      } catch (error) {
        console.error("Error making transfer:", error);
        alert("Transfer failed");
      }
    });

    // Weekly points functionality
    async function loadWeeklyPoints() {
      const gw = document.getElementById("gwInput").value;
      if (!gw || gw < 1 || gw > 38) {
        alert("Please enter a valid gameweek (1-38)");
        return;
      }
      
      try {
        const res = await fetch(`getWeeklyPoints.php?gw=${gw}`);
        if (!res.ok) throw new Error("Failed to fetch weekly points");
        
        const data = await res.json();
        const container = document.getElementById("weeklyPoints");
        
        if (data.error) {
          container.innerHTML = `<div class="alert alert-info">${data.error}</div>`;
          return;
        }
        
        container.innerHTML = `
          <h5>Gameweek ${gw} Points: ${data.points}</h5>
          <p>Rank: ${data.rank}</p>
        `;
      } catch (error) {
        console.error("Error loading weekly points:", error);
        document.getElementById("weeklyPoints").innerHTML = 
          `<div class="alert alert-danger">Failed to load weekly points: ${error.message}</div>`;
      }
    }

    // League standings functionality
    async function loadLeagueStandings() {
      const gw = document.getElementById("leagueGwInput").value;
      if (!gw || gw < 1 || gw > 38) {
        alert("Please enter a valid gameweek (1-38)");
        return;
      }
      
      try {
        const res = await fetch(`getLeagueStandings.php?gw=${gw}`);
        if (!res.ok) throw new Error("Failed to fetch league standings");
        
        const data = await res.json();
        const container = document.getElementById("leagueStandings");
        container.innerHTML = "";
        
        if (data.error) {
          container.innerHTML = `<div class="alert alert-info">${data.error}</div>`;
          return;
        }
        
        let html = `<h5>Gameweek ${gw} Standings</h5><table class="table table-striped"><thead><tr><th>Rank</th><th>Team</th><th>Points</th></tr></thead><tbody>`;
        
        data.standings.forEach(team => {
          html += `<tr><td>${team.rank}</td><td>${team.team_name}</td><td>${team.points}</td></tr>`;
        });
        
        html += "</tbody></table>";
        container.innerHTML = html;
      } catch (error) {
        console.error("Error loading league standings:", error);
        document.getElementById("leagueStandings").innerHTML = 
          `<div class="alert alert-danger">Failed to load league standings: ${error.message}</div>`;
      }
    }

    // Load fixtures
    async function loadFixtures() {
      try {
        const res = await fetch("getFixtures.php");
        if (!res.ok) throw new Error("Failed to fetch fixtures");
        
        const data = await res.json();
        const container = document.getElementById("fixturesList");
        container.innerHTML = "";
        
        if (data.error) {
          container.innerHTML = `<li class="list-group-item">${data.error}</li>`;
          return;
        }
        
        data.fixtures.slice(0, 10).forEach(fixture => {
          container.innerHTML += `
            <li class="list-group-item d-flex justify-content-between">
              <span>${fixture.team_h} vs ${fixture.team_a}</span>
              <span class="text-muted">GW${fixture.event}</span>
            </li>
          `;
        });
      } catch (error) {
        console.error("Error loading fixtures:", error);
        document.getElementById("fixturesList").innerHTML = 
          `<li class="list-group-item">Failed to load fixtures: ${error.message}</li>`;
      }
    }

    // Load transfer suggestions
    async function loadTransferSuggestions() {
      try {
        const res = await fetch("getTransferSuggestions.php");
        if (!res.ok) throw new Error("Failed to fetch transfer suggestions");
        
        const data = await res.json();
        const container = document.getElementById("transferSuggestions");
        
        if (data.error) {
          container.innerHTML = data.error;
          return;
        }
        
        let html = "<ul>";
        data.suggestions.forEach(suggestion => {
          html += `<li>${suggestion}</li>`;
        });
        html += "</ul>";
        
        container.innerHTML = html;
      } catch (error) {
        console.error("Error loading transfer suggestions:", error);
        document.getElementById("transferSuggestions").innerHTML = 
          `Failed to load transfer suggestions: ${error.message}`;
      }
    }

    // Initialize everything when page loads
    document.addEventListener("DOMContentLoaded", function() {
      loadPlayerOptions();
      loadSavedTeam();
      loadFixtures();
      loadTransferSuggestions();
      
      // Load notifications
      fetch("getNotifications.php")
        .then(res => res.json())
        .then(data => {
          const container = document.getElementById("notifications");
          if (data.error) {
            container.innerHTML = `<div class="alert alert-info">${data.error}</div>`;
          } else {
            data.notifications.forEach(notification => {
              container.innerHTML += `<div class="alert alert-warning">${notification}</div>`;
            });
          }
        })
        .catch(error => {
          console.error("Error loading notifications:", error);
        });
    });
  </script>
</body>
</html>
[file content end]