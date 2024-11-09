<?php
include('../config.php');
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $faculty_id = $_GET['id'];

    // Fetch faculty details
    $sql = "SELECT * FROM faculty WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $faculty_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $faculty = $result->fetch_assoc();

    // Fetch knowledge upgrade details from various tables
    $tables = [
        'knowledge_upgrade_fdp' => "SELECT * FROM knowledge_upgrade_fdp WHERE faculty_id = ?",
        'knowledge_upgrade_industrial' => "SELECT * FROM knowledge_upgrade_industrial WHERE faculty_id = ?",
        'knowledge_upgrade_nptel' => "SELECT * FROM knowledge_upgrade_nptel WHERE faculty_id = ?",
        'knowledge_upgrade_workshop' => "SELECT * FROM knowledge_upgrade_workshop WHERE faculty_id = ?"
    ];

    $knowledge_data = [];

    foreach ($tables as $key => $query) {
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $faculty_id);
        $stmt->execute();
        $knowledge_data[$key] = $stmt->get_result();
    }
}
// Fetch research details
$research_tables = [
    'conferences' => "SELECT * FROM conferences WHERE faculty_id = ?",
    'journals' => "SELECT * FROM journals WHERE faculty_id = ?",
    'patents' => "SELECT * FROM patents WHERE faculty_id = ?",
    'consultancy' => "SELECT * FROM consultancy WHERE faculty_id = ?"
];

$research_data = [];

foreach ($research_tables as $key => $query) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $faculty_id);
    $stmt->execute();
    $research_data[$key] = $stmt->get_result();
}

    // Fetch recognition details
    $sql_recognition = "SELECT * FROM recognition WHERE faculty_id = ?";
    $stmt = $conn->prepare($sql_recognition);
    $stmt->bind_param('i', $faculty_id);
    $stmt->execute();
    $recognition_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<div class="container mt-4">
    <div class="card mb-4">
        <div class="row no-gutters">
            <div class="col-md-3">
                <img src="../uploads/faculty/<?php echo htmlspecialchars($faculty['profile_image']); ?>" alt="Faculty Image" class="card-img-top rounded-circle" style="width: 100%; height: auto; object-fit: cover;">
            </div>
            <div class="col-md-8">
                <div class="card-body">
					<h3>Faculty Profile</h3>
                    <h5 class="card-title"><?php echo htmlspecialchars($faculty['faculty_name']); ?></h5>
                    <p class="card-text"><strong>Email:</strong> <?php echo htmlspecialchars($faculty['email']); ?></p>
                    <p class="card-text"><strong>Department:</strong> <?php echo htmlspecialchars($faculty['department']); ?></p>
                    <p class="card-text"><strong>Phone:</strong> <?php echo htmlspecialchars($faculty['phone']); ?></p>
                    <p class="card-text"><strong>Date of Joining:</strong> <?php echo htmlspecialchars($faculty['date_of_joining']); ?></p>
                    <p class="card-text"><strong>Qualification:</strong> <?php echo htmlspecialchars($faculty['qualification']); ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Display knowledge upgrades from FDP -->
<br>
<h3>Knowledge Upgradation: FDP</h3>
<table class="table table-bordered">
    <tr>
        <th>Program Name</th>
        <th>Duration</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Certificate</th>
    </tr>
    <?php while ($row = $knowledge_data['knowledge_upgrade_fdp']->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['program_name']); ?></td>
        <td><?php echo htmlspecialchars($row['duration']); ?></td>
        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
        <td><a href="<?php echo htmlspecialchars($row['certificate']); ?>" target="_blank">View Certificate</a></td>
    </tr>
    <?php } ?>
</table>
<br>
<!-- Display knowledge upgrades from Industrial -->
<h3>Knowledge Upgradation: Industrial</h3>
<table class="table table-bordered">
    <tr>
        <th>Company Name</th>
        <th>Duration</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Description</th>
        <th>Certificate</th>
    </tr>
    <?php while ($row = $knowledge_data['knowledge_upgrade_industrial']->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['company_name']); ?></td>
        <td><?php echo htmlspecialchars($row['duration']); ?></td>
        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>
        <td><a href="<?php echo htmlspecialchars($row['certificate']); ?>" target="_blank">View Certificate</a></td>
    </tr>
    <?php } ?>
</table>
<br>
<!-- Display knowledge upgrades from NPTEL -->
<h3>Knowledge Upgradation: NPTEL</h3>
<table class="table table-bordered">
    <tr>
        <th>Course Name</th>
        <th>Instructor Name</th>
        <th>Institution Name</th>
        <th>Duration</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Certificate</th>
    </tr>
    <?php while ($row = $knowledge_data['knowledge_upgrade_nptel']->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['course_name']); ?></td>
        <td><?php echo htmlspecialchars($row['instructor_name']); ?></td>
        <td><?php echo htmlspecialchars($row['institution_name']); ?></td>
        <td><?php echo htmlspecialchars($row['duration']); ?></td>
        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
        <td><a href="<?php echo htmlspecialchars($row['certificate']); ?>" target="_blank">View Certificate</a></td>
    </tr>
    <?php } ?>
</table>
<br>
<!-- Display knowledge upgrades from Workshops -->
<h3>Knowledge Upgradation: Workshops</h3>
<table class="table table-bordered">
    <tr>
        <th>Workshop Name</th>
        <th>Duration</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Description</th>
        <th>Certificate</th>
    </tr>
    <?php while ($row = $knowledge_data['knowledge_upgrade_workshop']->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['workshop_name']); ?></td>
        <td><?php echo htmlspecialchars($row['duration']); ?></td>
        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>
        <td><a href="<?php echo htmlspecialchars($row['certificate']); ?>" target="_blank">View Certificate</a></td>
    </tr>
    <?php } ?>
</table>
<br>
<!-- Display faculty recognition -->
<h3>Recognition</h3>
<table class="table table-bordered">
    <tr>
        <th>Award Name</th>
        <th>Date</th>
        <th>Description</th>
        <th>Photo/Certificate</th>
    </tr>
    <?php while ($row = $recognition_result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['award_name']); ?></td>
        <td><?php echo htmlspecialchars($row['date']); ?></td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>
        <td><a href="<?php echo htmlspecialchars($row['photo']); ?>" target="_blank">View Certificate</a></td>
    </tr>
    <?php } ?>
</table>
<br>
<!-- Display faculty research -->
<h3>Research: Conferences</h3>
<table class="table table-bordered">
    <tr>
        <th>Conference Name</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Abstract</th>
        <th>File</th>
    </tr>
    <?php while ($row = $research_data['conferences']->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['conference_name']); ?></td>
        <td><?php echo htmlspecialchars($row['start_date']); ?></td>
        <td><?php echo htmlspecialchars($row['end_date']); ?></td>
        <td><?php echo htmlspecialchars($row['abstract']); ?></td>
        <td><a href="<?php echo htmlspecialchars($row['certification_link']); ?>" target="_blank">View File</a></td>
    </tr>
    <?php } ?>
</table>
<br>
<h3>Research: Journals</h3>
<table class="table table-bordered">
    <tr>
        <th>Journal Name</th>
        <th>Publication Date</th>
        <th>Paper Link</th>
    </tr>
    <?php while ($row = $research_data['journals']->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['journal_name']); ?></td>
        <td><?php echo htmlspecialchars($row['publication_date']); ?></td>
        <td><a href="<?php echo htmlspecialchars($row['paper_link']); ?>" target="_blank">View Paper</a></td>
    </tr>
    <?php } ?>
</table>
<br>
<h3>Research: Patents</h3>
<table class="table table-bordered">
    <tr>
        <th>Product Name</th>
        <th>Publication Year</th>
        <th>Description</th>
        <th>Report Link</th>
    </tr>
    <?php while ($row = $research_data['patents']->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
        <td><?php echo htmlspecialchars($row['year_of_publication']); ?></td>
        <td><?php echo htmlspecialchars($row['description']); ?></td>
        <td><a href="<?php echo htmlspecialchars($row['report_link']); ?>" target="_blank">View Report</a></td>
    </tr>
    <?php } ?>
</table>
<br>
<h3>Research: Consultancy</h3>
<table class="table table-bordered">
    <tr>
        <th>Consultancy Type</th>
        <th>Company Name</th>
        <th>Year</th>
        <th>Worth</th>
    </tr>
    <?php while ($row = $research_data['consultancy']->fetch_assoc()) { ?>
    <tr>
        <td><?php echo htmlspecialchars($row['consultancy_type']); ?></td>
        <td><?php echo htmlspecialchars($row['company_name']); ?></td>
        <td><?php echo htmlspecialchars($row['year']); ?></td>
        <td><?php echo htmlspecialchars($row['worth']); ?></td>
    </tr>
    <?php } ?>
</table>

<a href="generate_pdf.php?faculty_id=<?php echo $faculty_id; ?>" class="btn btn-secondary">Download PDF</a>
