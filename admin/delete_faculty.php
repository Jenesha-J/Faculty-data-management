<?php
include('../config.php');
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: ../index.php");
    exit;
}

if (isset($_GET['id'])) {
    $faculty_id = $_GET['id'];

    // Delete the faculty record
    $sql_delete = "DELETE FROM faculty WHERE id = ?";
    $stmt = $conn->prepare($sql_delete);
    $stmt->bind_param('i', $faculty_id);

    if ($stmt->execute()) {
        echo "Faculty deleted successfully!";
        header("Location: manage_faculty.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
