<?php
session_start();
require '../includes/db_conn.php'; // Assuming db_conn.php sets up your PDO connection

?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <title>University Edit</title>
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
                        <h4>University Edit 
                            <a href="index.php" class="btn btn-danger float-end">BACK</a>
                        </h4>
                    </div>
                    <div class="card-body">

                        <?php
                        if(isset($_GET['id']))
                        {
                            // Fetch the university ID from the URL
                            $university_id = $_GET['id'];

                            try {
                                // Prepare and execute the query to fetch the university details by ID
                                $query = "SELECT * FROM universities WHERE id = :university_id";
                                $stmt = $con->prepare($query);
                                $stmt->bindParam(':university_id', $university_id, PDO::PARAM_INT);
                                $stmt->execute();
                                
                                if($stmt->rowCount() > 0)
                                {
                                    $university = $stmt->fetch(PDO::FETCH_ASSOC);

                                    // Define the uploads directory path
                                    $upload_dir = '../uploads/';
                                    $image_path = $upload_dir . $university['image']; // Append image file name to the uploads directory
                                ?>

                                <!-- IMAGE -->
                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="university_id" value="<?= htmlspecialchars($university_id); ?>">
                                    <!-- Flex Container for Input Field and Button -->
                                    <div class="d-flex align-items-end gap-4">
                                        <div class="flex-grow-1">
                                            <label for="new_image" class="form-label">Upload New Image</label>
                                            <input type="file" name="new_image" id="new_image" class="form-control" accept="image/*" required>
                                        </div>
                                        <button type="submit" name="update_image" class="btn btn-primary">Update Image</button>
                                    </div>
                                </form>
                                <!-- IMAGE -->

                                <form action="code.php" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="university_id" value="<?= htmlspecialchars($university['id']); ?>">

                                    <div class="mb-3">
                                        <label>University Image</label>
                                        <div>
                                            <?php if (!empty($university['image']) && file_exists($image_path)): ?>
                                                <img src="<?= htmlspecialchars($image_path); ?>" 
                                                    alt="Uploaded Image" 
                                                    style="width: 200px; height: 200px; object-fit: cover; border: 1px solid #ccc; border-radius: 8px;">
                                            <?php else: ?>
                                                <b>No Image!</b>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="my-3">
                                        <label>University Name</label>
                                        <input type="text" name="university_name" value="<?= htmlspecialchars($university['university_name']); ?>" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label>University Address</label>
                                        <input type="text" name="university_address" value="<?= htmlspecialchars($university['university_address']); ?>" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <button type="submit" name="update_university" class="btn btn-primary">
                                            Update University
                                        </button>
                                    </div>

                                </form>
                                <?php
                                }
                                else
                                {
                                    echo "<h4>No University Found with that ID</h4>";
                                }
                            } catch (PDOException $e) {
                                echo "<h4>Error: " . $e->getMessage() . "</h4>";
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
