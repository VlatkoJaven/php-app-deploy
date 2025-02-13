<?php
session_start();
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

    <title>University Create</title>
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
                <h4>University Add 
                    <a href="index.php" class="btn btn-danger float-end">BACK</a>
                </h4>
            </div>
            <div class="card-body">
                <form action="code.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label>University Name</label>
                                <input type="text" name="university_name" class="form-control">
                            </div>
                            <div class="mb-3"> 
                                <label>University Address</label>
                                <input type="text" name="university_address" class="form-control">
                            </div>

                            <div class="mb-3">
                                <label>University Image</label>
                                <input type="file" class="form-control" name="image" id="image" accept="image/*" required>
                            </div>
                        
                            <div class="mb-3">
                                <button type="submit" name="save_university" class="btn btn-primary">Save University</button>
                            </div>

                        </form>
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