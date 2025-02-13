<?php
    session_start();
    require '../includes/db_conn.php';
    // Check if the user is logged in, if not then redirect him to login page
    if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
        header("location: ../login.php");
        exit;
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

    <title>Universities CRUD</title>
</head>
<body>

    <!-- Header Start -->
    <?php include_once '../components/header.php';?>
    <!-- Header End -->

    <!-- Body start -->
    <div class="container my-5">
        <?php include('message.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Universities Details
                            <a href="university-create.php" class="btn btn-primary float-end">Add university</a>
                        </h4>
                    </div>
                    <div class="card-body">

                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>university Name</th>
                                <th>university Address</th>
                                <th>university Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $query = "SELECT * FROM universities";
                                $query_run = $con->query($query);

                                if($query_run->rowCount() > 0)
                                {
                                    foreach($query_run as $university)
                                    {
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($university['id']); ?></td>
                                            <td>
                                                <img 
                                                    src="../uploads/<?= htmlspecialchars($university['image']); ?>" 
                                                    alt="university Image" 
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;"
                                                >
                                            </td>
                                            <td><?= htmlspecialchars($university['university_name']); ?></td>
                                            <td><?= htmlspecialchars($university['university_address']); ?></td>
                                            
                                            <td>
                                                <a href="university-edit.php?id=<?= $university['id']; ?>" class="btn btn-success btn-sm">Edit</a>
                                                <form action="code.php" method="POST" class="d-inline">
                                                    <button type="submit" name="delete_university" value="<?= $university['id']; ?>" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                else
                                { 
                                    echo "<h5> No Record Found </h5>";
                                } 
                            ?>
                        </tbody>
                    </table>

                    </div>
                </div>
            </div>
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
