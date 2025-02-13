<?php
session_start();
require '../includes/db_conn.php'; // Ensure db_conn.php uses PDO for database connection
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>Student Edit</title>
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
                <h4>Student Edit 
                  <a href="index.php" class="btn btn-danger float-end">BACK</a>
                </h4>
              </div>
              <div class="card-body">

                <?php
                if (isset($_GET['id'])) {
                  $student_id = $_GET['id'];

                  // PDO query to fetch student details
                  $stmt = $con->prepare("SELECT * FROM students WHERE id = :id");
                  $stmt->execute(['id' => $student_id]);
                  $student = $stmt->fetch(PDO::FETCH_ASSOC);

                  if ($student) {
                    $upload_dir = '../uploads/';
                    $image_path = $upload_dir . $student['image'];
                ?>

                <!-- IMAGE UPDATE FORM -->
                <form action="code.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="student_id" value="<?= htmlspecialchars($student_id); ?>">
                  <div class="d-flex align-items-end gap-4">
                    <div class="flex-grow-1">
                      <label for="new_image" class="form-label">Upload New Image</label>
                      <input type="file" name="new_image" id="new_image" class="form-control" accept="image/*" required>
                    </div>
                    <button type="submit" name="update_image" class="btn btn-primary">Update Image</button>
                  </div>
                </form>

                <!-- STUDENT DETAILS FORM -->
                <form action="code.php" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="student_id" value="<?= $student['id']; ?>">

                  <div class="mb-3">
                    <label>Student Image</label>
                    <div>
                      <?php if (!empty($student['image']) && file_exists($image_path)): ?>
                        <img src="<?= htmlspecialchars($image_path); ?>" alt="Uploaded Image" style="width: 200px; height: 200px; object-fit: cover; border: 1px solid #ccc; border-radius: 8px;">
                      <?php else: ?>
                        <b>No Image!</b>
                      <?php endif; ?>
                    </div>
                  </div>

                  <div class="my-3">
                    <label>Student Name</label>
                    <input type="text" name="name" value="<?= $student['name']; ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Student Email</label>
                    <input type="email" name="email" value="<?= $student['email']; ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Student Phone</label>
                    <input type="text" name="phone" value="<?= $student['phone']; ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Student Course</label>
                    <input type="text" name="course" value="<?= $student['course']; ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Student Birthday</label>
                    <input type="date" name="birthday" value="<?= $student['birthday']; ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Gender</label>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" value="male" <?= ($student['gender'] === 'male') ? 'checked' : ''; ?>>
                      <label class="form-check-label">Male</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="gender" value="female" <?= ($student['gender'] === 'female') ? 'checked' : ''; ?>>
                      <label class="form-check-label">Female</label>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label>Student Address</label>
                    <input type="text" name="address" value="<?= $student['address']; ?>" class="form-control">
                  </div>

                  <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" name="status" id="status" value="1" <?= isset($student['status']) && $student['status'] == 1 ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="status">Active</label>
                  </div>

                  <div class="mb-3">
                    <label for="university">Select University:</label>
                    <select name="university" id="university" class="form-control" required>
                      <option value="">Select a University</option>
                      <?php
                      // PDO query to get universities
                      $university_query = "SELECT id, university_name FROM universities";
                      $university_stmt = $con->query($university_query);

                      while ($row = $university_stmt->fetch(PDO::FETCH_ASSOC)) {
                        $selected = ($student['university'] == $row['id']) ? 'selected' : '';
                        echo "<option value='" . $row['id'] . "' $selected>" . $row['university_name'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>

                  <div class="mb-3">
                    <button type="submit" name="update_student" class="btn btn-primary">Update Student</button>
                  </div>

                </form>
                <?php
                  } else {
                    echo "<h4>No Such Id Found</h4>";
                  }
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
