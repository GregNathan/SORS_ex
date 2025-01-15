<?php
session_start();
include "DB_connection.php"; // Include your database connection

// Establish a database connection
$sName = "localhost";
$uName = "root";
$pass  = "";
$db_name = "sors_ex";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Define a function to approve a file or folder
function approve($id, $table, $column, $viewtype, $conn) {
    // Get file/folder details from the specified table
    $sql = "SELECT * FROM $table WHERE $column = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        // Determine filesize and filetype based on viewtype
        if ($viewtype === 'file') {
            $filesize = $data['filesize']; // Retain the original filesize
            $filetype = $data['filetype']; // Retain the original filetype
        } else {
            $filesize = 0; // Set filesize to 0 for folders
            $filetype = 'container'; // Set filetype to 'container' for folders
        }

        // Insert into files_final
        $sql = "INSERT INTO files_final (name, filesize, filetype, viewtype, file_path, uploaded_by, approved_by) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$data['filename'] ?? $data['foldername'], $filesize, $filetype, $viewtype, $data['file_path'], $data['uploaded_by'], $_SESSION['username']]);

        // Delete from files_pending or files_pending2
        $sql = "DELETE FROM $table WHERE $column = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);

        return true;
    }

    return false;
}

// Check if a file or folder is being approved
if (isset($_GET['file_id'])) {
    $id = $_GET['file_id'];
    $table = 'files_pending';
    $column = 'file_id';
    $viewtype = 'file';
} elseif (isset($_GET['folder_id'])) {
    $id = $_GET['folder_id'];
    $table = 'files_pending2';
    $column = 'folder_id';
    $viewtype = 'folder';
} else {
    header("Location: view_pending_files.php?error=Invalid+request");
    exit;
}

// Approve the file or folder
if (approve($id, $table, $column, $viewtype, $conn)) {
    header("Location: view_pending_files.php?message=File+approved+successfully");
} else {
    header("Location: view_pending_files.php?error=Failed+to+approve+file");
}
?>