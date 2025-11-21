[file name]: login.php
[file content begin]
<?php
session_start();
include 'db.php';

$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if it's a login attempt
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM users WHERE email=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($row = $result->fetch_assoc()) {
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                header("Location: dashboard.php");
                exit();
            } else {
                $login_error = "Invalid password.";
            }
        } else {
            $login_error = "User not found.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>FPL - Login/Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body.bg-light {
      background-color: #f8f9fa !important;
    }
    .card {
      border: none;
      border-radius: 10px;
    }
    .btn-success {
      background-color: #198754;
      border-color: #198754;
    }
    .btn-success:hover {
      background-color: #0f6848;
      border-color: #0f6848;
    }
  </style>
</head>
<body class="bg-light">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
      <a class="navbar-brand fw-bold text-success" href="index.html">FPL Champ</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="players.html">Players</a></li>
          <li class="nav-item"><a class="nav-link" href="fixtures.html">Fixtures</a></li>
          <li class="nav-item"><a class="nav-link active" href="login.php">Login</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Login/Register Section -->
  <section class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow p-4">
          <h3 class="text-center mb-4">Login to FPL Champ</h3>
          
          <!-- Display login error if any -->
          <?php if (!empty($login_error)): ?>
            <div class="alert alert-danger"><?php echo $login_error; ?></div>
          <?php endif; ?>
          
          <form action="login.php" method="POST">
            <div class="mb-3">
              <label>Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
              <label>Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Login</button>
          </form>
          
          <hr>
          <p class="text-center text-muted">Don't have an account?</p>
          <button class="btn btn-outline-success w-100" data-bs-toggle="modal" data-bs-target="#registerModal">
            Register
          </button>
        </div>
      </div>
    </div>
  </section>

  <!-- Register Modal -->
  <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content p-4">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">Create Account</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form action="register.php" method="POST">
            <div class="mb-3">
              <label for="regName" class="form-label">Full Name</label>
              <input type="text" class="form-control" id="regName" name="name" placeholder="Enter full name" required>
            </div>
            <div class="mb-3">
              <label for="regEmail" class="form-label">Email address</label>
              <input type="email" class="form-control" id="regEmail" name="email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
              <label for="regPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="regPassword" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Register</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer class="bg-dark text-white text-center py-3 mt-5">
    <p class="mb-0">&copy; 2025 FPL Champ. All rights reserved.</p>
    <div>
      <a href="#" class="text-success mx-2">Facebook</a> |
      <a href="#" class="text-success mx-2">Twitter</a> |
      <a href="#" class="text-success mx-2">Instagram</a>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
[file content end]