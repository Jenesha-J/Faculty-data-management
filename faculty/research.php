<?php
include('../config.php');
// Get faculty ID from session
$faculty_id = $faculty['id'];;
/*
// Fetch research details from each table based on faculty_id
$sql_conference = "SELECT 'Conference' AS category, title AS name, date, description, file_upload FROM conferences WHERE faculty_id='$faculty_id'";
$sql_journal = "SELECT 'Journal' AS category, title AS name, date, description, file_upload FROM journals WHERE faculty_id='$faculty_id'";
$sql_patent = "SELECT 'Patent' AS category, title AS name, date, description, file_upload FROM patents WHERE faculty_id='$faculty_id'";
$sql_consultancy = "SELECT 'Consultancy' AS category, title AS name,date,worth, file_upload FROM consultancy WHERE faculty_id='$faculty_id'";
*/
$sql_conference = "SELECT 'Conference' AS category, title AS name, start_date, end_date,abstract, certification_link AS file_upload FROM conferences WHERE faculty_id='$faculty_id'";
$sql_journal = "SELECT 'Journal' AS category, journal_name AS name, publication_date AS date, paper_link AS file_upload FROM journals WHERE faculty_id='$faculty_id'";
$sql_patent = "SELECT 'Patent' AS category, product_name AS name, year_of_publication AS date, description, report_link AS file_upload FROM patents WHERE faculty_id='$faculty_id'";
$sql_consultancy = "SELECT 'Consultancy' AS category, consultancy_type AS name, year AS date, worth FROM consultancy WHERE faculty_id='$faculty_id'";


// Execute queries
$result_conference = $conn->query($sql_conference);
$result_journal = $conn->query($sql_journal);
$result_patent = $conn->query($sql_patent);
$result_consultancy = $conn->query($sql_consultancy);

// Combine all results into a single array
$all_results = [];

if ($result_conference && $result_conference->num_rows > 0) {
    $all_results = array_merge($all_results, $result_conference->fetch_all(MYSQLI_ASSOC));
}

if ($result_journal && $result_journal->num_rows > 0) {
    $all_results = array_merge($all_results, $result_journal->fetch_all(MYSQLI_ASSOC));
}

if ($result_patent && $result_patent->num_rows > 0) {
    $all_results = array_merge($all_results, $result_patent->fetch_all(MYSQLI_ASSOC));
}

if ($result_consultancy && $result_consultancy->num_rows > 0) {
    $all_results = array_merge($all_results, $result_consultancy->fetch_all(MYSQLI_ASSOC));
}

// Insert new research detail
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_research'])) {
    $category = htmlspecialchars($_POST['category']);
    
    // Common fields
    /*$title = htmlspecialchars($_POST['title']);
    $date = htmlspecialchars($_POST['date']);
    $description = htmlspecialchars($_POST['description']);
    $file_upload = htmlspecialchars($_POST['file_upload']); */
    
    // Prepare SQL query based on selected category
    switch ($category) {
        case 'Conference':
            $conference_name = htmlspecialchars($_POST['conference_name']);
            $type = htmlspecialchars($_POST['type']);
            $city = htmlspecialchars($_POST['city']);
            $country = htmlspecialchars($_POST['country']);
            $start_date = htmlspecialchars($_POST['start_date']);
            $end_date = htmlspecialchars($_POST['end_date']);
            $contribution_type = htmlspecialchars($_POST['contribution_type']);
            $abstract = htmlspecialchars($_POST['abstract']);
            $co_authors = htmlspecialchars($_POST['co_authors']);
            $student_ids = htmlspecialchars($_POST['student_ids']);
            $student_names = htmlspecialchars($_POST['student_names']);
            $certification_link = htmlspecialchars($_POST['certification_link']);
            
            $sql_insert = "INSERT INTO conferences (faculty_id, conference_name, type, city, country, start_date, end_date, title, contribution_type, abstract, co_authors, student_ids, student_names, certification_link)
                           VALUES ('$faculty_id', '$conference_name', '$type', '$city', '$country', '$start_date', '$end_date', '$title', '$contribution_type', '$abstract', '$co_authors', '$student_ids', '$student_names', '$certification_link')";
            break;

        case 'Journal':
            $journal_name = htmlspecialchars($_POST['journal_name']);
            $publication_date = htmlspecialchars($_POST['publication_date']);
            $scopus_sci = htmlspecialchars($_POST['scopus_sci']);
            $paper_link = htmlspecialchars($_POST['paper_link']);
            
            $sql_insert = "INSERT INTO journals (faculty_id, journal_name, publication_date, scopus_sci, paper_link)
                           VALUES ('$faculty_id', '$journal_name', '$publication_date', '$scopus_sci', '$paper_link')";
            break;

        case 'Patent':
            $product_name = htmlspecialchars($_POST['product_name']);
            $year_of_publication = htmlspecialchars($_POST['year_of_publication']);
            $status = htmlspecialchars($_POST['status']);
            $report_link = htmlspecialchars($_POST['report_link']);
            
            $sql_insert = "INSERT INTO patents (faculty_id, product_name, description, year_of_publication, status, report_link)
                           VALUES ('$faculty_id', '$product_name', '$description', '$year_of_publication', '$status', '$report_link')";
            break;

        case 'Consultancy':
            $consultancy_type = htmlspecialchars($_POST['consultancy_type']);
            $company_name = htmlspecialchars($_POST['company_name']);
            $year = htmlspecialchars($_POST['year']);
            $worth = htmlspecialchars($_POST['worth']);
            
            $sql_insert = "INSERT INTO consultancy (faculty_id, consultancy_type, company_name, year, worth)
                           VALUES ('$faculty_id', '$consultancy_type', '$company_name', '$year', '$worth')";
            break;
    }

    // Execute insert query
    if ($conn->query($sql_insert) === TRUE) {
        echo "New research detail added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<h3>Your Research</h3>

<div>
    <h4>Conferences</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Description</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result_conference as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($row['abstract']); ?></td>
                    <td>
                        <?php if (!empty($row['file_upload'])) { ?>
                            <a href="<?php echo htmlspecialchars($row['file_upload']); ?>" target="_blank">View file</a>
                        <?php } else { ?>
                            No file link provided
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div>
    <h4>Journals</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Publication Date</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result_journal as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td>
                        <?php if (!empty($row['file_upload'])) { ?>
                            <a href="<?php echo htmlspecialchars($row['file_upload']); ?>" target="_blank">View file</a>
                        <?php } else { ?>
                            No file link provided
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div>
    <h4>Patents</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Publication Year</th>
                <th>Description</th>
                <th>File</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result_patent as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['description']); ?></td>
                    <td>
                        <?php if (!empty($row['file_upload'])) { ?>
                            <a href="<?php echo htmlspecialchars($row['file_upload']); ?>" target="_blank">View file</a>
                        <?php } else { ?>
                            No file link provided
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<div>
    <h4>Consultancies</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Year</th>
                <th>Worth</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($result_consultancy as $row) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['worth']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<h2>Add Research</h2>

<!-- Form to Add New Research -->
<form method="POST" id="researchform">
    <div class="form-group">
        <label for="category">Category:</label>
        <div class="col-md-6">
            <select name="category" id="category" class="form-control" required>
                <option value="">Select Category</option>
                <option value="Conference">Conference</option>
                <option value="Journal">Journal</option>
                <option value="Patent">Patent</option>
                <option value="Consultancy">Consultancy</option>
            </select>
        </div>
    </div>

    <!-- Dynamic fields will be populated here -->
    <div id="dynamicfieldsElement"></div>

    <div class="form-group">
        <div class="col-md-6">
            <button type="submit" name="add_research" class="btn btn-primary">Add Research</button>
        </div>
    </div>
</form>

<script>
    researchform.category.addEventListener('change', function() {
        const category = this.value;
        const dynamicFields = document.getElementById('dynamicfieldsElement');
        dynamicFields.innerHTML = ''; // Clear existing fields

        let fields = '';

        if (category === 'Conference') {
            fields = `
                <div class="form-group col-md-6">
                    <label>Conference Name:</label>
                    <input type="text" name="conference_name" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Type:</label>
                    <select name="type" class="form-control" required>
                        <option value="National">National</option>
                        <option value="International">International</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>City:</label>
                    <input type="text" name="city" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Country:</label>
                    <input type="text" name="country" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Start Date:</label>
                    <input type="date" name="start_date" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>End Date:</label>
                    <input type="date" name="end_date" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Title of Paper/Presentation:</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Type of Contribution:</label>
                    <select name="contribution_type" class="form-control" required>
                        <option value="Oral Presentation">Oral Presentation</option>
                        <option value="Poster">Poster</option>
                        <option value="Workshop">Workshop</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Abstract:</label>
                    <textarea name="abstract" class="form-control" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>Co-authors:</label>
                    <input type="text" name="co_authors" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Student IDs:</label>
                    <input type="text" name="student_ids" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label>Student Names:</label>
                    <textarea name="student_names" class="form-control"></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>Certification Link:</label>
                    <input type="url" name="certification_link" class="form-control">
                </div>
            `;
        } else if (category === 'Journal') {
            fields = `
                <div class="form-group col-md-6">
                    <label>Journal Name:</label>
                    <input type="text" name="journal_name" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Publication Date:</label>
                    <input type="date" name="publication_date" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Scopus/Sci:</label>
                    <select name="scopus_sci" class="form-control" required>
                        <option value="Scopus">Scopus</option>
                        <option value="Sci">Sci</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Paper Link:</label>
                    <input type="url" name="paper_link" class="form-control" required>
                </div>
            `;
        } else if (category === 'Patent') {
            fields = `
                <div class="form-group col-md-6">
                    <label>Product Name:</label>
                    <input type="text" name="product_name" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Description:</label>
                    <textarea name="description" class="form-control" required></textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>Year of Publication:</label>
                    <input type="number" name="year_of_publication" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Status:</label>
                    <select name="status" class="form-control" required>
                        <option value="Granted">Granted</option>
                        <option value="Pending">Pending</option>
                        <option value="Rejected">Rejected</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>Report Link:</label>
                    <input type="url" name="report_link" class="form-control">
                </div>
            `;
        } else if (category === 'Consultancy') {
            fields = `
                <div class="form-group col-md-6">
                    <label>Type of Consultancy:</label>
                    <input type="text" name="consultancy_type" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Name of Company:</label>
                    <input type="text" name="company_name" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Year:</label>
                    <input type="number" name="year" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label>Worth:</label>
                    <input type="number" name="worth" class="form-control" step="0.01" required>
                </div>
            `;
        }

        dynamicFields.innerHTML = fields;
    });
</script>
