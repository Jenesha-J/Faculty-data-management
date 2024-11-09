<?php
include('config.php');
session_start();
$error_message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];  // Admin or Faculty

    if ($role == 'admin') {
        $sql = "SELECT * FROM admin WHERE username='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $_SESSION['admin'] = $email;
            header("Location: admin/dashboard.php");
			exit();
        } else {
            //echo "Invalid admin credentials";
			$error_message = "Invalid admin credentials";
        }
    } else {
        $sql = "SELECT * FROM faculty WHERE email='$email' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {
            $_SESSION['faculty'] = $email;
            header("Location: faculty/dashboard.php");
			exit();
        } else {
            //echo "Invalid faculty credentials";
			$error_message = "Invalid faculty credentials";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="css/index_style.css">
</head>
<body>
<div class=login-container >
<div class="header-image"></div>
<h2>Admin/Faculty Login</h2>
    <form method="POST" action="">
	    <select name="role" required>
            <option value="admin">Admin</option>
            <option value="faculty">Faculty</option>
        </select>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
		<br><br>
		<a href="forgot_password.php">forgot password?</a>
		
		
		<h4 style="margin-bottom: 20px; color: #2196f3; text-align: left;font-size: 24px;">Is this your first time here?</h4>
		<h5 style="text-align: left;">Username: Email ID</h5>
		<h5 style="text-align: left;">Password:12345678</h5>
		<h5 style="text-align: left;">Set your own password in first-time login</h5>
		<p id="error-message" style="color: red; display: none;"></p>
		
		        <?php if (!empty($error_message)): ?>
            <script>
                document.getElementById('error-message').innerText = "<?php echo addslashes($error_message); ?>"; // Safely escape the message
                document.getElementById('error-message').style.display = 'block'; // Show the error message
            </script>
        <?php endif; ?>

    </form>
	</div>
</body>
</html>
