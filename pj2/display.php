<?php  session_start();
if(!isset($_SESSION['access'])){
  header('location:loginform.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Voting System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
      <a class="navbar-brand" href="#">Voting System</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="login.html">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="register.html">Register</a></li>
          <li class="nav-item"><a class="nav-link" href="loginform.php">Logout</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Polls Section -->
  <div class="container my-5">
    <h2 class="text-center mb-4">Active Polls</h2>
    <div class="row" id="pollsContainer">
      <!-- Poll Card Example -->
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h5 class="card-title">Favorite Programming Language?</h5>
            <p class="card-text">Vote for your favorite programming language.</p>
            <form>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="poll1" id="option1">
                <label class="form-check-label" for="option1">Python</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="poll1" id="option2">
                <label class="form-check-label" for="option2">JavaScript</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="poll1" id="option3">
                <label class="form-check-label" for="option3">Java</label>
              </div>
              <button type="submit" class="btn btn-primary mt-3">Vote</button>
            </form>
          </div>
        </div>
      </div>
      <!-- Add more polls here dynamically from backend -->
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
