<?php
session_start();
include('../config.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $faculty_name = $_POST['faculty_name'];
    $email = $_POST['email'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $date_of_joining = $_POST['date_of_joining'];
    $qualification = $_POST['qualification'];

    // Handle the profile image upload
    $profile_image = $_FILES['profile_image']['name'];
    $target = "../uploads/faculty/" . basename($profile_image);
    move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);

    // Insert into the database
    $sql = "INSERT INTO faculty (faculty_name, email, department, phone, profile_image, date_of_joining, qualification) 
            VALUES ('$faculty_name', '$email', '$department', '$phone', '$profile_image', '$date_of_joining', '$qualification')";

    if ($conn->query($sql) === TRUE) {
        header("Location: manage_faculty.php"); // Redirect to manage faculty page after insertion
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Faculty</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f8f9fa; /* Light gray background */
        }
        .form-container {
            background-color: #ffffff; /* White background for the form */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="container form-container">
        <h2 class="mb-4">Add New Faculty</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="faculty_name">Faculty Name:</label>
                <input type="text" class="form-control" name="faculty_name" id="faculty_name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" class="form-control" name="department" id="department" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" name="phone" id="phone">
            </div>
            <div class="form-group">
                <label for="profile_image">Profile Image:</label>
                <input type="file" class="form-control-file" name="profile_image" id="profile_image">
            </div>
            <div class="form-group">
                <label for="date_of_joining">Date of Joining:</label>
                <input type="date" class="form-control" name="date_of_joining" id="doj" required>
            </div>
            <div class="form-group">
                <label for="qualification">Qualification:</label>
                <input type="text" class="form-control" name="qualification" id="Qualification" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Faculty</button>
        </form>
    </div>
</body>
</html>
