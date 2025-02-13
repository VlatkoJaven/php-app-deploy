<?php
session_start();
require '../includes/db_conn.php'; // Include the PDO connection file
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

    <title>Student Create</title>
</head>
<body>

   <!-- Header Start -->
   <?php require_once "../components/header.php" ?>
    <!-- Header End -->

    <div class="d-flex flex-column min-vh-100">
        <div class="container mt-5">

<?php include('message.php'); ?>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4>Student Add 
                    <a href="index.php" class="btn btn-danger float-end">BACK</a>
                </h4>
            </div>
            <div class="card-body">
            <form action="code.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Student Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="mb-3"> 
                    <label>Student Email</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Student Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Student Course</label>
                    <input type="text" name="course" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Student Birthday</label>
                    <input type="date" name="birthday" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Student Image</label>
                    <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                </div>
                <div class="mb-3">
                    <label>Gender</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="male">
                        <label class="form-check-label">Male</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" value="female">
                        <label class="form-check-label">Female</label>
                    </div>
                </div>
                <div class="mb-3">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control">
                </div>
                <div class="mb-3 form-check">
                    <input 
                        type="checkbox" 
                        class="form-check-input" 
                        name="status" 
                        id="status" 
                        value="1">
                    <label class="form-check-label" for="status">Active</label>
                </div>
                <div class="mb-3">
                    <label for="university">Select University:</label>
                    <select name="university" id="university" class="form-control" required>
                        <option value="">Select a University</option>
                        <?php
                        try {
                            // Fetch universities using PDO
                            $university_query = "SELECT id, university_name FROM universities";
                            $stmt = $con->prepare($university_query);
                            $stmt->execute();
                            $universities = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if ($universities) {
                                foreach ($universities as $university) {
                                    echo "<option value='" . htmlspecialchars($university['id']) . "'>" . htmlspecialchars($university['university_name']) . "</option>";
                                }
                            } else {
                                echo "<option value=''>No universities available</option>";
                            }
                        } catch (PDOException $e) {
                            echo "<option value=''>Error fetching universities</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <button type="submit" name="save_student" class="btn btn-primary">Save Student</button>
                </div>
            </form>
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
