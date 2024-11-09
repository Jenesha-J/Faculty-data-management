<?php
session_start();
include('config.php'); // Include your database connection

$error_message = "";
$success_message = "";

// Check if the token is present in the URL
if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Check if the token is valid
    $result = $conn->query("SELECT * FROM faculty WHERE reset_token='$token'");
    if ($result->num_rows == 0) {
        die("Invalid token.");
    }

    // Process the password reset
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];

        if ($new_password === $confirm_password) {
            // Update the password in the database
            $conn->query("UPDATE faculty SET password='$new_password', reset_token=NULL WHERE reset_token='$token'");
            $success_message = "Password has been reset successfully!";
        } else {
            $error_message = "Passwords do not match.";
        }
    }
} else {
    die("No token provided.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Reset Password</title>
</head>
<body>
    <h2>Reset Password</h2>
    <form method="POST">
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit">Reset Password</button>
    </form>

    <?php if ($success_message): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
</body>
</html>
