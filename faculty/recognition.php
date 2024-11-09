<?php
include('../config.php');

// Fetch recognition details
$sql_recognition = "SELECT * FROM recognition WHERE faculty_id='{$faculty['id']}'";
$result_recognition = $conn->query($sql_recognition);

// Insert new recognition detail
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_recognition'])) {
    $award_name = htmlspecialchars($_POST['award_name']);
    $date = htmlspecialchars($_POST['date']);
    $description = htmlspecialchars($_POST['description']);
    
    // File upload handling
    $photo = htmlspecialchars($_POST['photo']);

    $sql_insert = "INSERT INTO recognition (faculty_id, award_name, date, description, photo) VALUES ('{$faculty['id']}', '$award_name', '$date', '$description', '$photo')";
    if($conn->query($sql_insert)===TRUE)
	{
		echo "New recognition detail added successfully!";
	}else {
        echo "Error: " . $conn->error;
    }
}
?>
<!-- Display Existing Recognitions -->
<h3>Your Recognitions</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Award Name</th>
            <th>Date</th>
            <th>Description</th>
            <th>Photo</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result_recognition->fetch_assoc()) { ?>
            <tr>
                <td><?php echo $row['award_name']; ?></td>
                <td><?php echo $row['date']; ?></td>
                <td><?php echo $row['description']; ?></td>
				<td>
                    <?php if (!empty($row['photo'])) { ?>
                        <a href="<?php echo htmlspecialchars($row['photo']); ?>" target="_blank">View Certificate</a>
                    <?php } else { ?>
                        No certificate link provided
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<h2>Recognition</h2>
<!-- Form to Add New Recognition -->
<form method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <div class="col-md-6">
            <label for="award_name">Award Name:</label>
            <input type="text" name="award_name" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6">
            <label for="date">Date:</label>
            <input type="date" name="date" class="form-control" required>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6">
            <label for="photo">Certificate/Photo Link:</label>
            <input type="url" name="photo" class="form-control" placeholder="Enter Google Drive Link" required>
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6">
            <button type="submit" name="add_recognition" class="btn btn-primary">Add Recognition</button>
        </div>
    </div>
</form>


