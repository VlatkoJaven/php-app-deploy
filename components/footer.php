<?php

// Base URL for the project
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/";

// Start the session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in; redirect to login if not
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: " . $base_url . "login.php");
    exit;
}
?>

<!-- Footer -->
<footer class="text-center text-lg-start bg-primary text-muted mt-5">

  <!-- Section: Links  -->
  <section class="text-white">
    <div class="container text-center text-md-start mt-5 py-4">
      <!-- Grid row -->
      <div class="row mt-3">
        <!-- Grid column -->
        <div class="col-md-3 col-lg-4 col-xl-3 mx-auto mb-4">
          <!-- Content -->
          <h6 class="text-uppercase fw-bold mb-4">
            Cosmic Development
          </h6>
          <p>
          Our People are our Greatest Asset
          We Build Winning Teams for Brands
          Dedicated Employees, Top-Notch Teams, Unmatched Assets.
          </p>
         <a href="<?php echo $base_url; ?>welcome.php">
         <img src="<?php echo $base_url; ?>images/logoCosmic.png" alt="Logo">
         </a> 
        
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Company
          </h6>
          <p>
            <a href="#!" class="nav-link text-white">About Us</a>
          </p>
          <p>
            <a href="#!" class="nav-link text-white">Team</a>
          </p>
          <p>
            <a href="#!" class="nav-link text-white">Projects</a>
          </p>
          <p>
            <a href="#!" class="nav-link text-white">Rumble</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">
            Useful links
          </h6>
          <p>
            <a href="<?php echo $base_url; ?>students/index.php" class="nav-link text-white">Students</a>
          </p>
          <p>
            <a href="#!" class="nav-link text-white">Universities</a>
          </p>
          <p>
            <a href="#!" class="nav-link text-white">Courses</a>
          </p>
          <p>
            <a href="#!" class="nav-link text-white">Programs</a>
          </p>
        </div>
        <!-- Grid column -->

        <!-- Grid column -->
        <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mb-md-0 mb-4">
          <!-- Links -->
          <h6 class="text-uppercase fw-bold mb-4">Contact</h6>
          <p><i class="bi bi-geo-alt"></i> Rokdajl,18, KAM Building, 3rd floor, 7000 Bitola</p>
          <p><i class="bi bi-envelope"></i> info@cosmicdevelopment.com</p>
          <p><i class="bi bi-telephone"></i> +389 47 610 111</p>
            <div class="d-flex align-items-center">
                <a href="https://www.facebook.com/cosmicdevelopment/" target="_blank"><i class="bi bi-facebook fs-5 me-2 text-white"></i></a> 
                <a href="https://www.instagram.com/cosmicdevelopment/" target="_blank"><i class="bi bi-instagram fs-5 m-2 text-white"></i></a> 
                <a href="https://x.com/cosmicdevelopment" target="_blank"><i class="bi bi-twitter-x fs-5 m-2 text-white"></i></a> 
                <a href="https://www.linkedin.com/company/cosmic-development/mycompany/verification/" target="_blank"><i class="bi bi-linkedin fs-5 m-2 text-white"></i></a> 
            </div>
        </div>
        <!-- Grid column -->
         
      </div>
      <!-- Grid row -->
    </div>
  </section>
  <!-- Section: Links  -->

  <!-- Copyright -->
  <div class="text-center p-4 text-white" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2024 Copyright:
    <a class="text-reset fw-bold" href="https://www.cosmicdevelopment.com/">Cosmic Development</a>
  </div>
  <!-- Copyright -->
</footer>
<!-- Footer -->