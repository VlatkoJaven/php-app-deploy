<?php
session_start();
require '../includes/db_conn.php'; // Assuming this file sets up PDO connection
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Student View</title>
</head>
<body>

    <!-- Header Start -->
    <?php require_once "../components/header.php" ?>
    <!-- Header End -->
    <div class="d-flex flex-column min-vh-100">
        <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Student View Details
                            <a href="index.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                    <?php
                        if (isset($_GET['id'])) {
                            // Sanitize and fetch student ID from the URL
                            $student_id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);

                            // Query to fetch student details using PDO
                            $query = "
                            SELECT students.*, universities.university_name AS university_name
                            FROM students
                            LEFT JOIN universities ON students.university = universities.id
                            WHERE students.id = :student_id";

                            // Prepare the query
                            $stmt = $con->prepare($query);

                            // Bind the student_id to the query
                            $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);

                            // Execute the query
                            $stmt->execute();

                            if ($stmt->rowCount() > 0) {
                                // Fetch student data
                                $student = $stmt->fetch(PDO::FETCH_ASSOC);
                                
                                // Define the uploads directory path
                                $upload_dir = '../uploads/';
                                $image_path = $upload_dir . $student['image']; // Append image file name to the uploads directory
                                ?>
                                <div class="mb-3">
                                    <label>Student Image</label>
                                    <div>
                                        <?php if (!empty($student['image']) && file_exists($image_path)): ?>
                                            <img src="<?= htmlspecialchars($image_path); ?>" 
                                                alt="Uploaded Image" 
                                                style="width: 200px; height: 200px; object-fit: cover; border: 1px solid #ccc; border-radius: 8px;">
                                        <?php else: ?>
                                            <b>No Image !</b>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label>Student Name</label>
                                    <p class="form-control">
                                        <?= htmlspecialchars($student['name']); ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>Student Email</label>
                                    <p class="form-control">
                                        <?= htmlspecialchars($student['email']); ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>Student Phone</label>
                                    <p class="form-control">
                                        <?= htmlspecialchars($student['phone']); ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>Student Course</label>
                                    <p class="form-control">
                                        <?= htmlspecialchars($student['course']); ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>Student Birthday</label>
                                    <p class="form-control">
                                        <?= htmlspecialchars($student['birthday']); ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>Student Gender</label>
                                    <p class="form-control">
                                        <?= htmlspecialchars($student['gender']); ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>Student Address</label>
                                    <p class="form-control">
                                        <?= htmlspecialchars($student['address']); ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>Status</label>
                                    <p class="form-control">
                                        <?= $student['status'] == 1 ? "Student Active" : "Student Inactive"; ?>
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label>University</label>
                                    <p class="form-control">
                                        <?= htmlspecialchars($student['university_name']); ?>
                                    </p>
                                </div>

                                <?php
                            } else {
                                // Display message if the ID is invalid
                                echo "<h4>No Such ID Found</h4>";
                            }
                        } else {
                            echo "<h4>Invalid Request</h4>";
                        }
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
 <!-- Footer Section -->
 <?php include "../components/footer.php"?>
        <!-- footer-end -->
    </div>

  <!-- Bootstrap 5 -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>
