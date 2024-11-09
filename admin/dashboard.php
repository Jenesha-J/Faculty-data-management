<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .btn-custom {
            width: 200px; /* Adjust the width as needed */
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Welcome, Admin</h1>
        <div class="d-flex flex-column align-items-start">
            <a href="manage_faculty.php" class="btn btn-primary mb-2 btn-custom">Manage Faculty</a>
            <a href="../logout.php" class="btn btn-secondary btn-custom">Logout</a><br>
			<a href="../changepasswd.php">Change password?</a>
        </div>
    </div>
</body>
</html>
