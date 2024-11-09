<?php
include('../config.php');

// Fetch knowledge details from each table based on faculty_id
$faculty_id = $faculty['id'];

// Fetching from each category table
$sql_fdp = "SELECT 'FDP' AS category, program_name AS name, duration, start_date AS date, end_date, certificate FROM knowledge_upgrade_fdp WHERE faculty_id='$faculty_id'";
$sql_nptel = "SELECT 'NPTEL' AS category, course_name AS name, duration, start_date AS date, end_date, certificate FROM knowledge_upgrade_nptel WHERE faculty_id='$faculty_id'";
$sql_industrial = "SELECT 'Industrial Knowledge' AS category, company_name AS name, duration, start_date AS date, end_date, description, certificate FROM knowledge_upgrade_industrial WHERE faculty_id='$faculty_id'";
$sql_workshop = "SELECT 'Workshop' AS category, workshop_name AS name, duration, start_date AS date, end_date, certificate FROM knowledge_upgrade_workshop WHERE faculty_id='$faculty_id'";

// Execute queries
$result_fdp = $conn->query($sql_fdp);
$result_nptel = $conn->query($sql_nptel);
$result_industrial = $conn->query($sql_industrial);
$result_workshop = $conn->query($sql_workshop);

// Combine all results into a single array
$all_results = [];
if ($result_fdp) $all_results = array_merge($all_results, $result_fdp->fetch_all(MYSQLI_ASSOC));
if ($result_nptel) $all_results = array_merge($all_results, $result_nptel->fetch_all(MYSQLI_ASSOC));
if ($result_industrial) $all_results = array_merge($all_results, $result_industrial->fetch_all(MYSQLI_ASSOC));
if ($result_workshop) $all_results = array_merge($all_results, $result_workshop->fetch_all(MYSQLI_ASSOC));

// Insert new knowledge detail
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_knowledge'])) {
    $category = htmlspecialchars($_POST['category']);
    $faculty_id = htmlspecialchars($faculty['id']);
    $duration = htmlspecialchars($_POST['duration']);
    $certificate = htmlspecialchars($_POST['certificate']);
    $start_date = htmlspecialchars($_POST['start_date']);
    $end_date = htmlspecialchars($_POST['end_date']);
    
    // Prepare SQL query based on selected category
    switch ($category) {
        case 'FDP':
            $program_name = $conn->real_escape_string($_POST['program_name']);
            $sql_insert = "INSERT INTO knowledge_upgrade_fdp (faculty_id, program_name, duration, start_date, end_date, certificate) 
                           VALUES ('$faculty_id', '$program_name', '$duration', '$start_date', '$end_date', '$certificate')";
            break;

        case 'NPTEL':
            $course_name = $conn->real_escape_string($_POST['course_name']);
            $instructor_name = $conn->real_escape_string($_POST['instructor_name']);
            $institution_name = $conn->real_escape_string($_POST['institution_name']);
            $sql_insert = "INSERT INTO knowledge_upgrade_nptel (faculty_id, course_name, instructor_name, institution_name, duration, start_date, end_date, certificate) 
                           VALUES ('$faculty_id', '$course_name', '$instructor_name', '$institution_name', '$duration', '$start_date', '$end_date', '$certificate')";
            break;

        case 'Industrial Knowledge':
            $company_name = $conn->real_escape_string($_POST['company_name']);
            $description = $conn->real_escape_string($_POST['description']);
            $sql_insert = "INSERT INTO knowledge_upgrade_industrial (faculty_id, company_name, duration, start_date, end_date, description, certificate) 
                           VALUES ('$faculty_id', '$company_name', '$duration', '$start_date', '$end_date', '$description', '$certificate')";
            break;

        case 'Workshop':
            $workshop_name = $conn->real_escape_string($_POST['workshop_name']);
            $description = $conn->real_escape_string($_POST['description']);
            $sql_insert = "INSERT INTO knowledge_upgrade_workshop (faculty_id, workshop_name, duration, start_date, end_date, certificate, description) 
                           VALUES ('$faculty_id', '$workshop_name', '$duration', '$start_date', '$end_date', '$certificate', '$description')";
            break;
    }

    // Execute insert query
    if ($conn->query($sql_insert) === TRUE) {
        echo "New knowledge detail added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- Display Existing Knowledge -->
<h3>Your Knowledge Upgradation</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Category</th>
            <th>Name</th>
            <th>Duration</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Certificate</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($all_results as $row) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['category']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['duration']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                <td>
                    <?php if (!empty($row['certificate'])) { ?>
                        <a href="<?php echo htmlspecialchars($row['certificate']); ?>" target="_blank">View Certificate</a>
                    <?php } else { ?>
                        No certificate link provided
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<h2>Add Knowledge Upgradation</h2>

<!-- Form to Add New Knowledge -->
<form method="POST">
    <div class="form-group">
        <label for="category">Category:</label>
        <div class="col-md-6"> 
            <select name="category" id="category" class="form-control" required>
                <option value="">Select Category</option>
                <option value="FDP">FDP</option>
                <option value="NPTEL">NPTEL</option>
                <option value="Industrial Knowledge">Industrial Knowledge</option>
                <option value="Workshop">Workshop</option>
            </select>
        </div>
    </div>

    <!-- Dynamic fields will be populated here -->
    <div id="dynamicfields"></div>
    <br>
    <button type="submit" name="add_knowledge" class="btn btn-primary">Add Knowledge</button>
</form>

<script>
document.getElementById('category').addEventListener('change', function() {
    console.log("Category changed:", this.value);
    const category = this.value;
    const dynamicFields = document.getElementById('dynamicfields');
    dynamicFields.innerHTML = ''; // Clear existing fields

    let fields = '';

    if (category === 'FDP') {
        fields = `
            <div class="col-md-6">
                <label>Program Name:</label>
                <input type="text" name="program_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Duration:</label>
                <input type="number" name="duration" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Certificate Link:</label>
                <input type="url" name="certificate" class="form-control" placeholder="Enter Google Drive Link" required>
            </div>
        `;
    } else if (category === 'NPTEL') {
        fields = `
            <div class="col-md-6">
                <label>Course Name:</label>
                <input type="text" name="course_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Instructor Name:</label>
                <input type="text" name="instructor_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Institution Name:</label>
                <input type="text" name="institution_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Duration:</label>
                <input type="number" name="duration" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Certificate Link:</label>
                <input type="url" name="certificate" class="form-control" placeholder="Enter Google Drive Link" required>
            </div>
        `;
    } else if (category === 'Industrial Knowledge') {
        fields = `
            <div class="col-md-6">
                <label>Company Name:</label>
                <input type="text" name="company_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Duration:</label>
                <input type="number" name="duration" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Description:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="col-md-6">
                <label>Certificate Link:</label>
                <input type="url" name="certificate" class="form-control" placeholder="Enter Google Drive Link" required>
            </div>
        `;
    } else if (category === 'Workshop') {
        fields = `
            <div class="col-md-6">
                <label>Workshop Name:</label>
                <input type="text" name="workshop_name" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Duration:</label>
                <input type="number" name="duration" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>Start Date:</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label>End Date:</label>
                <input type="date" name="end_date" class="form-control">
            </div>
            <div class="col-md-6">
                <label>Certificate Link:</label>
                <input type="url" name="certificate" class="form-control" placeholder="Enter Google Drive Link" required>
            </div>
            <div class="col-md-6">
                <label>Description:</label>
                <textarea name="description" class="form-control"></textarea>
            </div>
        `;
    }
    
    // Insert dynamic fields
    dynamicFields.insertAdjacentHTML('beforeend', fields);
});
</script>

