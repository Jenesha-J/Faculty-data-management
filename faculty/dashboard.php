<?php
session_start();
if (!isset($_SESSION['faculty'])) {
    header("Location: ../index.php");
    exit;
}
include('../config.php');

// Fetch faculty details
$email = $_SESSION['faculty'];
$sql = "SELECT * FROM faculty WHERE email='$email'";
$result = $conn->query($sql);
$faculty = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Faculty Dashboard</title>
	<!--<link rel="stylesheet" href="../css/bootstrap.min.css">
    <script src="../js/bootstrap.min.js"></script> -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    <h1>Welcome, <?php echo $faculty['faculty_name']; ?></h1>
	
	<!-- Display Profile Image -->
        <div class="profile-image">
            <?php if (!empty($faculty['profile_image'])): ?>
                <img src="../uploads/faculty/<?php echo htmlspecialchars($faculty['profile_image']); ?>" alt="Profile Image" class="img-fluid" style="max-width: 200px; max-height: 200px;">
            <?php else: ?>
                <p>No profile image available.</p>
            <?php endif; ?>
        </div>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="knowledge-tab" data-toggle="tab" href="#knowledge" role="tab" aria-controls="knowledge" aria-selected="true">Knowledge Upgradation</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="recognition-tab" data-toggle="tab" href="#recognition" role="tab" aria-controls="recognition" aria-selected="false">Recognition</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="research-tab" data-toggle="tab" href="#research" role="tab" aria-controls="research" aria-selected="false">Research</a>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="myTabContent">
        <!-- Knowledge Upgradation -->
        <div class="tab-pane fade show active" id="knowledge" role="tabpanel" aria-labelledby="knowledge-tab">
            <?php include('knowledge.php'); ?>
        </div>

        <!-- Recognition -->
        <div class="tab-pane fade" id="recognition" role="tabpanel" aria-labelledby="recognition-tab">
            <?php include('recognition.php'); ?>
        </div>

        <!-- Research -->
        <div class="tab-pane fade" id="research" role="tabpanel" aria-labelledby="research-tab">
            <?php include('research.php'); ?>
        </div>
    </div>
	<br>
	<a href="../changepasswd.php">Change password?</a>
    <a href="../logout.php">Logout</a>
</body>
</html>
