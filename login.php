<?php
// Start the session at the very top, before any HTML or output
//session_start();

// Check if the user is already logged in, if yes then redirect to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: welcome.php");
    exit;
}

// Include config file
require_once "./includes/db_conn.php";

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, username, password FROM users WHERE username = :username";

        if ($stmt = $con->prepare($sql)) {
            // Bind parameters
            $stmt->bindParam(":username", $username, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if username exists, then verify password
                if ($stmt->rowCount() == 1) {
                    $user = $stmt->fetch(PDO::FETCH_ASSOC);
                    if (password_verify($password, $user["password"])) {
                        // Password is correct, start a new session
                        session_start();

                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["id"] = $user["id"];
                        $_SESSION["username"] = $user["username"];

                        // Redirect user to welcome page
                        header("location: welcome.php");
                        exit;
                    } else {
                        // Invalid password
                        $login_err = "Invalid username or password.";
                    }
                } else {
                    // Invalid username
                    $login_err = "Invalid username or password.";
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }

    // Close connection
    unset($con);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <div class="container mt-5 form-width">
        <form method="POST" action="login.php">
            <h1>Login</h1>
            <p>Please fill in your credentials to login.</p>

            <?php if (!empty($login_err)) : ?>
                <div class="alert alert-danger"><?php echo $login_err; ?></div>
            <?php endif; ?>

            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
                <span class="text-danger"><?php echo $username_err; ?></span>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password">
                <span class="text-danger"><?php echo $password_err; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
            <p>Don't have an account? <a href="signup.php">Sign up now.</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
