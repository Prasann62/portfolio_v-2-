


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Eventify - Book Your Events</title>
  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Roboto&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <style>
    /* Global Styles */
    body {
      font-family: 'Roboto', sans-serif;
      scroll-behavior: smooth;
    }
    a {
      text-decoration: none;
    }

    /* Navbar */
    .navbar {
      padding: 1rem 2rem;
      transition: 0.3s;
    }
    .navbar-brand {
      font-family: 'Montserrat', sans-serif;
      font-size: 1.8rem;
    }

    /* Hero Section */
    .hero {
      height: 100vh;
      background: url('./assets/hero-bg.jpg') no-repeat center center/cover;
      position: relative;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    .hero::before {
      content: '';
      position: absolute;
      top:0; left:0; width:100%; height:100%;
      background: rgba(0,0,0,0.6);
    }
    .hero .container {
      position: relative;
      z-index: 2;
    }
    .hero-title {
      font-size: 3rem;
      font-weight: 700;
    }
    .hero-subtitle {
      font-size: 1.3rem;
      margin-top: 0.5rem;
    }
    .hero-btn {
      font-size: 1.2rem;
      padding: 0.8rem 2rem;
      border-radius: 50px;
    }

    /* Events Section */
    #events .card {
      border: none;
      border-radius: 15px;
      transition: transform 0.3s, box-shadow 0.3s;
    }
    #events .card:hover {
      transform: translateY(-10px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
    #events .card-img-top {
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
      height: 220px;
      object-fit: cover;
    }

    /* About Section */
    #about h5 {
      font-weight: 700;
    }

    /* Testimonials */
    .testimonials {
      background: #f8f9fa;
      padding: 60px 0;
    }
    .testimonials .card {
      border: none;
      border-radius: 15px;
      transition: transform 0.3s;
    }
    .testimonials .card:hover {
      transform: translateY(-8px);
    }

    /* Contact Section */
    #contact .form-control {
      border-radius: 8px;
      padding: 12px 15px;
    }
    #contact button {
      border-radius: 50px;
      padding: 10px 25px;
    }
    .hero {
  position: relative;
  height: 100vh; /* Full screen */
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  text-align: center;
  overflow: hidden;
}

/* Background Video */
.hero-video {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover; /* Cover full section */
  z-index: -1; /* Push video behind content */
}

/* Dark overlay for text readability */
.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5); /* Adjust darkness */
  z-index: -1;
}

.hero {
  position: relative;
  height: 100vh; /* full screen */
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
  overflow: hidden;
}

.hero-bg {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;  /* makes image cover like a background */
  z-index: -2;
}

.overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,0.5); /* darkens image for readability */
  z-index: -1;
}

.hero .container {
  position: relative;
  z-index: 1;
}

.hero-title {
  font-size: 3rem;
  font-weight: bold;
}

.hero-subtitle {
  font-size: 1.3rem;
  margin-top: 0.5rem;
}


    /* Footer */
    footer a {
      color: #ffc107;
      margin: 0 10px;
      transition: color 0.3s;
    }
    footer a:hover {
      color: #fff;
    }
    
  


  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">Eventify</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center">
          <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="#events">Events</a></li>
          <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
          <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
          <li class="nav-item"><a class="btn btn-warning text-dark ms-2" href="#events">Book Now</a></li>
        </ul>
      </div>
    </div>
  </nav>

 <!-- Hero Section -->
<section class="hero">
  <!-- Background Image -->
  <img src="./assets/bd.2.jpg" alt="Background" class="hero-bg">

  <!-- Dark Overlay (optional) -->
  <div class="overlay"></div>

  <!-- Content -->
  <div class="container">
    <h1 class="hero-title">Music Fest 2025</h1>
    <p class="hero-subtitle">Join us for an unforgettable live concert experience!</p>
    <a href="#events" class="btn btn-lg btn-warning mt-3 hero-btn">Book Tickets</a>
  </div>
</section>


  <!-- Events Section -->
  <section id="events" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5">Upcoming Events</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="./assets/ev.1.jpg" class="card-img-top" alt="Event 1">
            <div class="card-body">
              <h5 class="card-title">MUSIC CONCERT</h5>
              <p>📅 20th September 2025</p>
              <p>⏰ 6:00 PM</p>
              <p>📍 Chennai Stadium</p>
              <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#bookingModal" data-event="MUSIC CONCERT - Chennai Stadium">Book Now</button>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="./assets/ev.2.jpg" class="card-img-top" alt="Event 2">
            <div class="card-body">
              <h5 class="card-title">DJ NIGHT PARTY</h5>
              <p>📅 31st August 2025</p>
              <p>⏰ 8:30 PM</p>
              <p>📍 Bangalore Club</p>
              <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#bookingModal" data-event="DJ NIGHT PARTY - Bangalore Club">Book Now</button>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="./assets/ev.3.jpg" class="card-img-top" alt="Event 3">
            <div class="card-body">
              <h5 class="card-title">MUSIC CONCERT</h5>
              <p>📅 30th September 2025</p>
              <p>⏰ 7:00 PM</p>
              <p>📍 Coimbatore Arena</p>
              <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#bookingModal" data-event="MUSIC CONCERT - Coimbatore Arena">Book Now</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Booking Modal (PHP logic untouched) -->
  <form action="index.php" method="POST">
    <div class="modal fade" id="bookingModal" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content p-3">
          <div class="modal-header">
            <h5 class="modal-title">Book Your Ticket</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Event</label>
              <input type="text" id="eventName" class="form-control" readonly name="evn">
            </div>
            <div class="mb-3">
              <label class="form-label">Your Name</label>
              <input type="text" class="form-control" placeholder="Enter your name" required name="nm">
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" placeholder="Enter your email" required name="em">
            </div>
            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="number" class="form-control" placeholder="Enter your mobile" required name="pho">
            </div>
            <div class="mb-3">
              <label class="form-label">Tickets</label>
              <input type="number" class="form-control" min="1" value="1" required name="noft">
            </div>
            <button type="submit" class="btn btn-success w-100" name="book">Confirm Booking</button>
          </div>
        </div>
      </div>
    </div>
  </form>

  <!-- About Section -->
  <section id="about" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5">About Eventify</h2>
      <div class="row align-items-center">
        <div class="col-md-6">
          <h5>🎉 Experience Unforgettable Moments</h5>
          <p>Eventify brings electrifying concerts, sports matches, and glamorous parties to life. Our mission is to create memorable experiences for everyone.</p>
          <h6>📍 Address</h6>
          <p>123 Event Street, Tamil Nadu, India</p>
          <h6>📧 Email</h6>
          <p>contact@eventify.com</p>
          <h6>📞 Phone</h6>
          <p>+91 98765 43210</p>
        </div>
        <div class="col-md-6 text-center">
          <img src="./assets/about.jpg" class="img-fluid rounded shadow" alt="About Image">
        </div>
      </div>
    </div>
  </section>

  <!-- Testimonials -->
  <section class="testimonials">
    <div class="container">
      <h2 class="text-center mb-5">What People Say</h2>
      <div class="row g-4">
        <div class="col-md-4">
          <div class="card shadow p-4 text-center">
            <img src="./assets/r.p.1.jpg" class="rounded-circle mb-3" width="80" height="80">
            <p>"Amazing experience! Loved the vibe and the performances."</p>
            <h6>- Rukmani Vasanth</h6>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow p-4 text-center">
            <img src="./assets/r.p.2.jpg" class="rounded-circle mb-3" width="80" height="80">
            <p>"The best event I’ve attended this year. Highly recommended!"</p>
            <h6>- Sai Pallavi</h6>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow p-4 text-center">
            <img src="./assets/sm.1.jpg" class="rounded-circle mb-3" width="80" height="80">
            <p>"Great organization and fantastic music. Can’t wait for the next one."</p>
            <h6>- SM</h6>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="py-5">
    <div class="container">
      <h2 class="text-center mb-5">Contact Us</h2>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <form onsubmit="sendWhatsApp(); return false;">
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input type="text" class="form-control" id="name" placeholder="Your Name" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" class="form-control" id="email" placeholder="Your Email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Message</label>
              <textarea class="form-control" rows="4" id="message" placeholder="Your Message" required></textarea>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary">Send Message</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer class="text-center py-3 bg-dark text-light">
    <div class="container">
      <p>
        <a href="#">Facebook</a> | 
        <a href="#">Instagram</a> | 
        <a href="#">Twitter</a>
      </p>
      <p>&copy; 2025 Eventify. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const bookingModal = document.getElementById('bookingModal');
    bookingModal.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const eventName = button.getAttribute('data-event');
      document.getElementById('eventName').value = eventName;
    });
    
    





    function sendWhatsApp() {
      const name = document.getElementById("name").value.trim();
      const email = document.getElementById("email").value.trim();
      const message = document.getElementById("message").value.trim();
      const text = `Name: ${name}%0AEmail: ${email}%0AMessage: ${message}`;
      const phone = "918608144068";
      window.open(`https://wa.me/${phone}?text=${text}`, "_blank");
    }
  </script>

<?php 
  
  if (isset($_POST['book'])) {
      $name  = $_POST['nm'];
      $email = $_POST['em'];  
      $pho   = $_POST['pho'];
      $noft  = $_POST['noft'];
      $event = $_POST['evn'];
  
      // Database connection
      $servername = "localhost";
      $username   = "u913997673_prasanna";
      $password   = "Ko%a/2klkcooj]@o";
      $dbname     = "u913997673_prasanna";
  
      $conn = new mysqli($servername, $username, $password, $dbname);
  
      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
  
      // Insert into database
      $sql = "INSERT INTO book (name,email,phone,noft,event) 
              VALUES ('$name','$email','$pho','$noft','$event')";
  
      if ($conn->query($sql) === TRUE) {
          // Success message
          echo "<script>
              Swal.fire({
                title: '✅ Booking Confirmed!',
                text: 'Your booking details have been saved in the database.',
                icon: 'success',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
                customClass: {
                  title: 'swal2-title-custom',
                  popup: 'swal2-popup-custom'
                }
              }).then(() => {
                window.location.href='index.php';
              });
          </script>";
  
          // Send Email after successful booking
          $to = $email;
          $subject = "Your Event Booking Confirmation";
          $message = "Hello $name,\n\nThank you for booking with us!\n\n".
                     "Name: $name\nEmail: $email\nPhone: $pho\nTickets: $noft\nEvent: $event\n\n".
                     "We will contact you soon.\n\nRegards,\nEvent Team";
  
          $headers = "From: no-reply@prasanna.techmerise.com";
  
          if (mail($to, $subject, $message, $headers)) {
              echo "<script>alert('📩 Confirmation email sent to $email');</script>";
          } else {
              echo "<script>alert('⚠️ Failed to send confirmation email');</script>";
          }
  
      } else {
          // Error inserting data
          echo "<script>
              Swal.fire({
                title: '❌ Error!',
                text: 'Booking could not be saved.',
                icon: 'error',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#d33'
              });
          </script>";
      }
  
      $conn->close();
  }
  ?>
  


</body>
</html>
