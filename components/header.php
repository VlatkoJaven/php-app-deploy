<?php

// Base URL for the project
$base_url = "http://" . $_SERVER['HTTP_HOST'] . "/php-app-deploy/";

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
<nav class="navbar navbar-expand-lg bg-primary py-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $base_url; ?>welcome.php">
            <img src="<?php echo $base_url; ?>images/logoCosmic.png" alt="Logo" width="200" height="35">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-white" href="<?php echo $base_url; ?>welcome.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo $base_url; ?>students/index.php">Students</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo $base_url; ?>universities/index.php">Universities</a>
                </li>
            
            </ul>
            <form class="d-flex" role="search">
                <h5 class="text-white me-2 mt-2"><?php echo htmlspecialchars($_SESSION["username"]); ?>
                <i class="bi bi-person text-white fs-5"></i>    
                </h5>
            </form>
        </div>
    </div>
</nav>
