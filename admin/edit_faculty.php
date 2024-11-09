<?php
session_start();
include('../config.php');

// Check if the admin is logged in
if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

// Check if faculty ID is provided
if (isset($_GET['id'])) {
    $faculty_id = $_GET['id'];

    // Fetch faculty details from the database
    $sql = "SELECT * FROM faculty WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $faculty_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        echo "No faculty found.";
        exit;
    }

    $faculty = $result->fetch_assoc();
} else {
    echo "Invalid request.";
    exit;
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $faculty_name = $_POST['faculty_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $department = $_POST['department'];
    $phone = $_POST['phone'];
    $date_of_joining = $_POST['date_of_joining'];
    $qualification = $_POST['qualification'];

    // Handle profile image upload if a new file is provided
    if (!empty($_FILES['profile_image']['name'])) {
        $profile_image = $_FILES['profile_image']['name'];
        $target = "../uploads/faculty/" . basename($profile_image);
        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);
    } else {
        $profile_image = $faculty['profile_image']; // Keep the old image if no new image is uploaded
    }

    // Update the faculty details in the database
    $sql = "UPDATE faculty SET faculty_name = ?, email = ?, password = ?, department = ?, phone = ?, profile_image = ?, date_of_joining = ?, qualification = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ssssssssi', $faculty_name, $email, $password, $department, $phone, $profile_image, $date_of_joining, $qualification, $faculty_id);

    if ($stmt->execute()) {
        header("Location: manage_faculty.php"); // Redirect after successful update
        exit;
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Faculty Profile</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #2196f3; /* Light gray background */
        }
        .form-container {
            background-color: #ffffff; /* White background for the form */
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="form-container col-md-6">
            <h2 class="mb-4 text-center">Edit Faculty Profile</h2>
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="faculty_name">Faculty Name:</label>
                    <input type="text" class="form-control" name="faculty_name" id="faculty_name" value="<?php echo htmlspecialchars($faculty['faculty_name']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" name="email" id="email" value="<?php echo htmlspecialchars($faculty['email']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" name="password" id="password" value="<?php echo htmlspecialchars($faculty['password']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="department">Department:</label>
                    <input type="text" class="form-control" name="department" id="department" value="<?php echo htmlspecialchars($faculty['department']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" name="phone" id="phone" value="<?php echo htmlspecialchars($faculty['phone']); ?>">
                </div>
                <div class="form-group">
                    <label for="profile_image">Profile Image:</label>
                    <input type="file" class="form-control-file" name="profile_image" id="profile_image">
                    <small class="form-text text-muted">Leave blank to keep the current image.</small>
                </div>
                <div class="form-group">
                    <label for="date_of_joining">Date of Joining:</label>
                    <input type="date" class="form-control" name="date_of_joining" id="doj" value="<?php echo htmlspecialchars($faculty['date_of_joining']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="qualification">Qualification:</label>
                    <input type="text" class="form-control" name="qualification" id="Qualification" value="<?php echo htmlspecialchars($faculty['qualification']); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Faculty</button>
            </form>
        </div>
    </div>
</body>
