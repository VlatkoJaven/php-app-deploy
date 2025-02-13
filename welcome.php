<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

include 'includes/db_conn.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
   
    <!-- Header Start -->
    <?php include_once 'components/header.php';?>
    <!-- Header End -->
      
    <!-- Main Content -->
    <section class="welcome"> 
        <div class="container d-flex justify-content-between py-4">
            <h3>Dashboard</h3>
            <div class="d-flex">
                <a href="<?php echo $base_url; ?>reset-password.php" class="btn btn-outline-primary">Reset Your Password</a>
                <a href="<?php echo $base_url; ?>logout.php" class="btn btn-outline-primary ms-2">Sign Out</a>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card border border-primary shadow">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-person text-primary fs-1"></i>
                            </div>
                            <?php
                                // Query to count the number of students
                                $query = "SELECT COUNT(*) AS total_students FROM students";
                                $stmt = $con->prepare($query);
                                $stmt->execute();
                                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                $total_students = $result ? $result['total_students'] : 0;
                            ?>
                            <h4 class="card-title">Students</h4>
                            <h6 class="card-subtitle mb-3 text-muted"><?= htmlspecialchars($total_students); ?></h6>
                            <a href="<?php echo $base_url; ?>students/index.php" class="btn btn-outline-primary">View All</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border border-primary shadow">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-building text-primary fs-1"></i>
                            </div>
                            <?php
                                // Query to count the number of universities
                                $query_university = "SELECT COUNT(*) AS total_universities FROM universities";
                                $stmt_university = $con->prepare($query_university);
                                $stmt_university->execute();
                                $result_university = $stmt_university->fetch(PDO::FETCH_ASSOC);
                                $total_universities = $result_university ? $result_university['total_universities'] : 0;
                            ?>
                            <h4 class="card-title">Universities</h4>
                            <h6 class="card-subtitle mb-3 text-muted"><?= htmlspecialchars($total_universities); ?></h6>
                            <a href="<?php echo $base_url; ?>universities/index.php" class="btn btn-outline-primary">View All</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border border-primary shadow">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="bi bi-book text-primary fs-1"></i>
                            </div>
                          
                            <h4 class="card-title">Courses</h4>
                            <h6 class="card-subtitle mb-3 text-muted">0</h6>
                            <a href="#" class="btn btn-outline-primary">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <?php include "components/footer.php"; ?>
    <!-- Footer End -->

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
