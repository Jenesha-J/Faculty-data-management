<?php
session_start();
include('config.php'); // Include your database connection

$error_message = "";
$success_message = "";

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $result = $conn->query("SELECT * FROM faculty WHERE email='$email'");
    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $_SESSION['reset_token'] = $token; // Store token in session

        // Store token in the database (optional, for verification)
        $conn->query("UPDATE faculty SET reset_token='$token' WHERE email='$email'");

        // Send email with the reset link
        $reset_link = "http://localhost/employee_management/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $reset_link";
        mail($email, $subject, $message); // Use a mail function or a library for better handling

        $success_message = "A password reset link has been sent to your email.";
    } else {
        $error_message = "Email not found.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Forgot Password</title>
</head>
<body>
    <h2>Forgot Password</h2>
    <form method="POST">
        <input type="email" name="email" placeholder="Enter your registered email" required>
        <button type="submit">Send Reset Link</button>
    </form>

    <?php if ($success_message): ?>
        <p><?php echo $success_message; ?></p>
    <?php endif; ?>
    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
</body>
</html>
