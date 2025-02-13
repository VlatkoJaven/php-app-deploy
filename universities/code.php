<?php
session_start();
require '../includes/db_conn.php';

if (isset($_POST['delete_university'])) {
    $university_id = htmlspecialchars($_POST['delete_university']);

    // Step 1: Retrieve the image file name from the database
    $query = "SELECT image FROM universities WHERE id = :university_id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':university_id', $university_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        $image_file = $student['image'];

        // Step 2: Define the path to the uploads folder
        $upload_dir = '../uploads/';
        $image_path = $upload_dir . $image_file;

        // Step 3: Delete the image file if it exists
        if (file_exists($image_path)) {
            unlink($image_path); // Deletes the image file
        }

        // Step 4: Delete the user record from the database
        $delete_query = "DELETE FROM universities WHERE id = :university_id";
        $delete_stmt = $con->prepare($delete_query);
        $delete_stmt->bindParam(':university_id', $university_id, PDO::PARAM_INT);
        
        if ($delete_stmt->execute()) {
            $_SESSION['message'] = "University image deleted successfully";
            header("Location: index.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Failed to delete university from database";
            header("Location: index.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "University not found";
        header("Location: index.php");
        exit(0);
    }
}

if (isset($_POST['update_university'])) {
    $university_id = htmlspecialchars($_POST['university_id']);
    $university_name = htmlspecialchars($_POST['university_name']);
    $university_address = htmlspecialchars($_POST['university_address']);

    $query = "UPDATE universities SET university_name = :university_name, university_address = :university_address WHERE id = :university_id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':university_name', $university_name, PDO::PARAM_STR);
    $stmt->bindParam(':university_address', $university_address, PDO::PARAM_STR);
    $stmt->bindParam(':university_id', $university_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = "University updated successfully";
        header("Location: index.php");
        exit(0);
    } else {
        $_SESSION['message'] = "University not updated";
        header("Location: index.php");
        exit(0);
    }
}

if (isset($_POST['save_university'])) {
    $university_name = htmlspecialchars($_POST['university_name']);
    $university_address = htmlspecialchars($_POST['university_address']);
    $newFileName = null;

    // Check if file is uploaded
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['image']['tmp_name'];
        $fileName = $_FILES['image']['name'];
        $fileSize = $_FILES['image']['size'];
        $fileType = $_FILES['image']['type'];

        // Validate file type
        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($fileType, $allowedFileTypes)) {
            $_SESSION['message'] = "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
            header("Location: university-create.php");
            exit();
        }

        // Validate file size (max 2MB)
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        if ($fileSize > $maxFileSize) {
            $_SESSION['message'] = "File size exceeds 2MB limit.";
            header("Location: university-create.php");
            exit();
        }

        // Generate a unique name for the image
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('university_', true) . '.' . $fileExtension;

        // Define upload directory
        $uploadFileDir = '../uploads/';
        $destPath = $uploadFileDir . $newFileName;

        // Ensure the upload directory exists
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        // Move the uploaded file
        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            $_SESSION['message'] = "Failed to upload image.";
            header("Location: university-create.php");
            exit();
        }
    }

    // Insert data into the database
    $query = "INSERT INTO universities (university_name, university_address, image) VALUES (:university_name, :university_address, :image)";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':university_name', $university_name, PDO::PARAM_STR);
    $stmt->bindParam(':university_address', $university_address, PDO::PARAM_STR);
    $stmt->bindParam(':image', $newFileName, PDO::PARAM_STR);

    if ($stmt->execute()) {
        $_SESSION['message'] = "University created successfully";
        header("Location: university-create.php");
        exit(0);
    } else {
        $_SESSION['message'] = "University not created: " . $stmt->errorInfo()[2];
        header("Location: university-create.php");
        exit(0);
    }
}

if (isset($_POST['update_image'])) {
    $university_id = htmlspecialchars($_POST['university_id']);

    // Retrieve the old image name
    $query = "SELECT image FROM universities WHERE id = :university_id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':university_id', $university_id, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $student = $stmt->fetch(PDO::FETCH_ASSOC);
        $old_image = $student['image'];

        // Path to the uploads folder
        $upload_dir = '../uploads/';

        // Check if a new file is uploaded
        if (isset($_FILES['new_image']) && $_FILES['new_image']['error'] == 0) {
            $new_image_name = basename($_FILES['new_image']['name']);
            $new_image_path = $upload_dir . $new_image_name;

            // Move the new image to the uploads folder
            if (move_uploaded_file($_FILES['new_image']['tmp_name'], $new_image_path)) {
                // Delete the old image if it exists
                $old_image_path = $upload_dir . $old_image;
                if (file_exists($old_image_path)) {
                    unlink($old_image_path);
                }

                // Update the database with the new image name
                $update_query = "UPDATE universities SET image = :image WHERE id = :university_id";
                $update_stmt = $con->prepare($update_query);
                $update_stmt->bindParam(':image', $new_image_name, PDO::PARAM_STR);
                $update_stmt->bindParam(':university_id', $university_id, PDO::PARAM_INT);

                if ($update_stmt->execute()) {
                    $_SESSION['message'] = "Image updated successfully";
                    header("Location: index.php");
                    exit(0);
                } else {
                    $_SESSION['message'] = "Failed to update the image in the database";
                }
            } else {
                $_SESSION['message'] = "Failed to upload the new image";
            }
        } else {
            $_SESSION['message'] = "No new image uploaded";
        }
    } else {
        $_SESSION['message'] = "University not found";
    }
}
?>
