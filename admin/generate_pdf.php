<?php
require_once('../tcpdf/tcpdf.php');
include('../config.php');

// Get faculty ID from URL
if (isset($_GET['faculty_id'])) {
    $faculty_id = $_GET['faculty_id'];

    // Fetch faculty details
    $stmt = $conn->prepare("SELECT * FROM faculty WHERE id = ?");
    $stmt->bind_param("i", $faculty_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $faculty = $result->fetch_assoc();
        
        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        // Add faculty details
        $pdf->Cell(0, 10, 'Faculty Profile', 0, 1, 'C');
        $pdf->Ln(10);
        $pdf->SetFont('helvetica', 'B', 12);
        
        // Faculty info
        $fields = [
            'Name' => $faculty['faculty_name'],
            'Email' => $faculty['email'],
            'Department' => $faculty['department'],
            'Phone' => $faculty['phone']
        ];
        
        foreach ($fields as $label => $value) {
            $pdf->Cell(40, 10, $label . ':', 0);
            $pdf->Cell(0, 10, htmlspecialchars($value), 0, 1);
        }

        // Profile Image
        $pdf->Ln(10);
        $pdf->Cell(0, 10, '', 0, 1); // Empty line for spacing

       /* // Create a table-like structure for the details and image
        $pdf->Cell(130); // Space before the image
        if (!empty($faculty['profile_image'])) {
            $pdf->Image('../uploads/faculty/' . $faculty['profile_image'], '', '', 50, 50, 'JPG', '', 'T', false, 300, '', false, false, 1, false, false, false);
        } */


        // Create separate tables for Knowledge Upgradation
        $knowledge_tables = [
            'knowledge_upgrade_fdp' => "SELECT * FROM knowledge_upgrade_fdp WHERE faculty_id = ?",
            'knowledge_upgrade_industrial' => "SELECT * FROM knowledge_upgrade_industrial WHERE faculty_id = ?",
            'knowledge_upgrade_nptel' => "SELECT * FROM knowledge_upgrade_nptel WHERE faculty_id = ?",
            'knowledge_upgrade_workshop' => "SELECT * FROM knowledge_upgrade_workshop WHERE faculty_id = ?"
        ];

        foreach ($knowledge_tables as $table_name => $query) {
            $pdf->Ln(10);
            $pdf->Cell(0, 10, ucfirst(str_replace('_', ' ', $table_name)), 0, 1, 'C');
            $pdf->Ln(5);
            $pdf->SetFont('helvetica', 'B', 12);
            $pdf->Cell(50, 10, 'Program Name', 1);
            $pdf->Cell(40, 10, 'Duration', 1);
            $pdf->Cell(50, 10, 'Start Date', 1);
            $pdf->Cell(50, 10, 'End Date', 1);
            $pdf->Ln();

            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $faculty_id);
            $stmt->execute();
            $result_knowledge = $stmt->get_result();

            while ($row = $result_knowledge->fetch_assoc()) {
                // Set values based on the table type
                $program_name = htmlspecialchars($row['program_name'] ?? $row['company_name'] ?? $row['course_name'] ?? $row['workshop_name']);
                $duration = htmlspecialchars($row['duration']);
                $start_date = htmlspecialchars($row['start_date']);
                $end_date = htmlspecialchars($row['end_date']);

                // Calculate height
                $height = max(
                    $pdf->getStringHeight(50, $program_name),
                    $pdf->getStringHeight(40, $duration),
                    $pdf->getStringHeight(50, $start_date),
                    $pdf->getStringHeight(50, $end_date)
                );

                // Set the same height for all cells in the row
                $pdf->Cell(50, $height, $program_name, 1);
                $pdf->Cell(40, $height, $duration, 1);
                $pdf->Cell(50, $height, $start_date, 1);
                $pdf->Cell(50, $height, $end_date, 1);
                $pdf->Ln();
            }
        }

        // Create separate tables for Research
        $research_tables = [
            'conferences' => "SELECT * FROM conferences WHERE faculty_id = ?",
            'journals' => "SELECT * FROM journals WHERE faculty_id = ?",
            'patents' => "SELECT * FROM patents WHERE faculty_id = ?",
            'consultancy' => "SELECT * FROM consultancy WHERE faculty_id = ?"
        ];

        foreach ($research_tables as $table_name => $query) {
            $pdf->Ln(10);
            $pdf->Cell(0, 10, ucfirst(str_replace('_', ' ', $table_name)), 0, 1, 'C');
            $pdf->Ln(5);
            $pdf->SetFont('helvetica', 'B', 12);

            // Adjust columns based on the table type
            if ($table_name === 'consultancy' || $table_name === 'journals') {
                $pdf->Cell(60, 10, 'Type', 1);
                $pdf->Cell(70, 10, 'Name', 1);
                $pdf->Cell(60, 10, 'Year', 1);
            } else {
                $pdf->Cell(40, 10, 'Type', 1);
                $pdf->Cell(40, 10, 'Name', 1);
                $pdf->Cell(40, 10, 'Year', 1);
                $pdf->Cell(70, 10, 'Description', 1);
            }
            $pdf->Ln();

            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $faculty_id);
            $stmt->execute();
            $result_research = $stmt->get_result();

            while ($row = $result_research->fetch_assoc()) {
                // Set values based on the research type
                $type = ucfirst($table_name);
                $name = htmlspecialchars($row['conference_name'] ?? $row['journal_name'] ?? $row['product_name'] ?? $row['consultancy_type']);

                // Determine the year based on the type of entry
                if (!empty($row['year_of_publication'])) {
                    $year = htmlspecialchars($row['year_of_publication']);
                } elseif (!empty($row['start_date'])) {
                    $year = htmlspecialchars($row['start_date']);
                } elseif (!empty($row['publication_date'])) {
                    $year = htmlspecialchars($row['publication_date']);
                } else {
                    $year = htmlspecialchars($row['year']);
                }

                // Set description only for patents and conferences
                if ($table_name === 'patents' || $table_name === 'conferences') {
                    $description = htmlspecialchars($row['abstract'] ?? $row['description'] ?? '');

                    // Calculate height
                    $height = max(
                        $pdf->getStringHeight(40, $type),
                        $pdf->getStringHeight(40, $name),
                        $pdf->getStringHeight(40, $year),
                        $pdf->getStringHeight(70, $description)
                    );

                    // Set the same height for all cells in the row
                    $pdf->Cell(40, $height, $type, 1);
                    $pdf->Cell(40, $height, $name, 1);
                    $pdf->Cell(40, $height, $year, 1);
                    $pdf->MultiCell(70, $height, $description, 1);
                } else {
                    // Calculate height without description
                    $height = max(
                        $pdf->getStringHeight(40, $type),
                        $pdf->getStringHeight(40, $name),
                        $pdf->getStringHeight(40, $year)
                    );

                    // Set the same height for all cells in the row
                    $pdf->Cell(60, $height, $type, 1);
                    $pdf->Cell(70, $height, $name, 1);
                    $pdf->Cell(60, $height, $year, 1);
                    $pdf->Ln();
                }
            }
        }

        // Output PDF as a download
        $pdf->Output('faculty_profile_' . $faculty_id . '.pdf', 'D');
    } else {
        echo "No faculty found with this ID.";
    }
} else {
    echo "No faculty ID provided.";
}
?>
