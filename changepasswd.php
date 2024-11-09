<?php
include('config.php');
session_start();

$error_message = "";
$success_message = "";

// Check if the user is logged in
if (!isset($_SESSION['admin']) && !isset($_SESSION['faculty'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Determine the user's role and get their email
    $email = isset($_SESSION['admin']) ? $_SESSION['admin'] : $_SESSION['faculty'];
    $role = isset($_SESSION['admin']) ? 'admin' : 'faculty';

    // Prepare the SQL statement for current password validation
    if ($role == 'admin') {
        $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    } else {
        $stmt = $conn->prepare("SELECT password FROM faculty WHERE email = ?");
    }
    
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify current password
        if ($current_password === $row['password']) {
            // Check if new passwords match
            if ($new_password === $confirm_password) {
                // Prepare the update statement
                if ($role == 'admin') {
                    $update_stmt = $conn->prepare("UPDATE admin SET password = ? WHERE username = ?");
                } else {
                    $update_stmt = $conn->prepare("UPDATE faculty SET password = ? WHERE email = ?");
                }

                $update_stmt->bind_param("ss", $new_password, $email);
                if ($update_stmt->execute()) {
                    $success_message = "Password changed successfully!";
                } else {
                    $error_message = "Error updating password: " . $conn->error;
                }
            } else {
                $error_message = "New passwords do not match.";
				//echo $error_message;
            }
        } else {
            $error_message = "Current password is incorrect.";
        }
    } else {
        $error_message = "User not found.";
    }

    $stmt->close();
    if (isset($update_stmt)) {
        $update_stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/index_style.css">
</head>
<body>
<div class="login-container">
    <h2>Change Password</h2>
    <form method="POST" action="">
        <input type="password" name="current_password" placeholder="Current Password" required>
        <input type="password" name="new_password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        <button type="submit">Change Password</button>
        
		<p id="error-message" style="color: red; display: none;"></p>

        <?php if (!empty($error_message)): ?>
            <script>
                document.getElementById('error-message').innerText = "<?php echo addslashes($error_message); ?>"; // Safely escape the message
                document.getElementById('error-message').style.display = 'block'; // Show the error message
            </script>
        <?php endif; ?>
		
        <?php if (!empty($success_message)): ?>
            <p class="success" style="color: green;"><?php echo $success_message; ?></p>
        <?php endif; ?>
    </form>
</div>
</body>
</html>
