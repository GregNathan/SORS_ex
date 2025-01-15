<?php
session_start();
include "DB_connection.php"; // Include your database connection

if (isset($_GET['file_id'])) {
    $file_id = $_GET['file_id'];

    // Delete from files_pending
    $sql = "DELETE FROM files_pending WHERE file_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$file_id]);

    header("Location: view_pending_files.php"); // Redirect back to pending files
    exit;
}
?>