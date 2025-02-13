<?php
session_start();
require '../includes/db_conn.php';

if (isset($_POST['delete_student'])) {
    $student_id = $_POST['delete_student'];

    // Step 1: Retrieve the image file name from the database
    $query = "SELECT image FROM students WHERE id = :student_id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
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
        $delete_query = "DELETE FROM students WHERE id = :student_id";
        $delete_stmt = $con->prepare($delete_query);
        $delete_stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
        if ($delete_stmt->execute()) {
            $_SESSION['message'] = "Student and associated image deleted successfully";
            header("Location: index.php");
            exit(0);
        } else {
            $_SESSION['message'] = "Failed to delete student from database";
            header("Location: index.php");
            exit(0);
        }
    } else {
        $_SESSION['message'] = "Student not found";
        header("Location: index.php");
        exit(0);
    }
}

if (isset($_POST['update_student'])) {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $university_id = $_POST['university'];

    // Update query
    $query = "UPDATE students SET name = :name, email = :email, phone = :phone, course = :course, birthday = :birthday, gender = :gender, address = :address, status = :status, university = :university_id WHERE id = :student_id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':birthday', $birthday);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':university_id', $university_id);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Student Updated Successfully";
        header("Location: index.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Student Not Updated";
        header("Location: index.php");
        exit(0);
    }
}

if (isset($_POST['save_student'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $course = $_POST['course'];
    $birthday = $_POST['birthday'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $status = $_POST['status'];
    $university_id = $_POST['university'];

    // Initialize file name
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
            header("Location: student-create.php");
            exit();
        }

        // Validate file size (max 2MB)
        $maxFileSize = 2 * 1024 * 1024; // 2MB
        if ($fileSize > $maxFileSize) {
            $_SESSION['message'] = "File size exceeds 2MB limit.";
            header("Location: student-create.php");
            exit();
        }

        // Generate a unique name for the image
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $newFileName = uniqid('student_', true) . '.' . $fileExtension;

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
            header("Location: student-create.php");
            exit();
        }
    }

    // Insert data into the database
    $query = "INSERT INTO students (name, email, phone, course, birthday, image, gender, address, status, university) VALUES (:name, :email, :phone, :course, :birthday, :image, :gender, :address, :status, :university_id)";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':course', $course);
    $stmt->bindParam(':birthday', $birthday);
    $stmt->bindParam(':image', $newFileName);
    $stmt->bindParam(':gender', $gender);
    $stmt->bindParam(':address', $address);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':university_id', $university_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Student Created Successfully";
        header("Location: index.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Student Not Created: " . $stmt->errorInfo()[2];
        header("Location: student-create.php");
        exit(0);
    }
}

// IMAGE EDIT
if (isset($_POST['update_image'])) {
    $student_id = $_POST['student_id'];

    // Retrieve the old image name
    $query = "SELECT image FROM students WHERE id = :student_id";
    $stmt = $con->prepare($query);
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
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
                $update_query = "UPDATE students SET image = :image WHERE id = :student_id";
                $update_stmt = $con->prepare($update_query);
                $update_stmt->bindParam(':image', $new_image_name);
                $update_stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);

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
        $_SESSION['message'] = "Student not found";
    }
}
?>
