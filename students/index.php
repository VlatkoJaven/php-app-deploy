<?php
session_start();
require '../includes/db_conn.php';

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../login.php");
    exit;
}

try {
    // Prepare and execute the query to fetch all students
    $query = "SELECT * FROM students";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['message'] = "Error: " . $e->getMessage();
    header("Location: index.php");
    exit(0);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../style/style.css">
    <style>
        .icon-button {
            background: none; 
            border: none;
            padding: 0;
            cursor: pointer;
            color: inherit;
        } 
    </style>
    <title>Student CRUD</title>
</head>
<body>

    <!-- Header Start -->
    <?php include_once '../components/header.php';?>
    <!-- Header End -->

    <!-- Body start -->
    <div class="container my-5">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">All Students</h4>
                        <a href="student-create.php" class="btn btn-primary">Add Students</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <?php
            if (count($students) > 0) {
                foreach ($students as $student) {
            ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100">
                            <div class="row g-0">
                                <!-- Image Column -->
                                <div class="col-3 d-flex align-items-center">
                                    <img src="../uploads/<?= htmlspecialchars($student['image']); ?>" 
                                         alt="Student Image" 
                                         class="img-fluid rounded-circle ms-3"
                                         style="width: 100px; height: 100px; object-fit: cover;">
                                </div>
                                <!-- Content Column -->
                                <div class="col-8 ps-2">
                                    <div class="card-body">
                                        <h5 class="card-title mb-1"><?= htmlspecialchars($student['name']); ?></h5>
                                        <p class="text-muted small mb-2"><b>Email:</b> <?= htmlspecialchars($student['email']); ?></p>
                                        <p class="text-muted  small mb-1"><b>Phone:</b> <?= htmlspecialchars($student['phone']); ?></p>
                                        <p class="text-muted  small text-truncate"><b>Course:</b> <?= htmlspecialchars($student['course']); ?></p>
                                        <div class="d-flex align-items-center">
                                            <a href="student-view.php?id=<?= $student['id']; ?>" class="text-primary me-2 fs-4">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                            <a href="student-edit.php?id=<?= $student['id']; ?>" class="text-warning me-2 fs-4">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="code.php" method="POST" class="d-inline">
                                                <button type="submit" name="delete_student" value="<?= $student['id']; ?>" class="icon-button">
                                                    <i class="bi bi-trash3 text-danger fs-4"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<div class='col-12'><h5>No Record Found</h5></div>";
            }
            ?>
        </div>
    </div>
    <!-- Body end -->

    <!-- Footer Section -->
    <?php include "../components/footer.php"?>
    <!-- footer-end -->

    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
