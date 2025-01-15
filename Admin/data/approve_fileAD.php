<?php
session_start();
include "./DB_connection.php"; // Include your database connection

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header("Location: /SORS_ex/approve_login.php"); // Redirect to admin login page
    exit;
}

$successMessage = ""; // Initialize success message variable

try {
    $conn = new PDO("mysql:host=localhost;dbname=sors_ex", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['file_id'])) {
        $file_id = $_POST['file_id'];
        $approved_by = $_SESSION['username']; // Get the admin's username from the session

        // Check if the approved_by variable is set
        if (empty($approved_by)) {
            echo "Error: Admin is not logged in.";
            exit;
        }

        // Update the file status to approved
        $sql = "UPDATE files_pending SET status = 'approved', approved_by = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$approved_by, $file_id]);

        // Check if the update was successful
        if ($stmt->rowCount() > 0) {
            $successMessage = "File approved successfully."; // Set success message
        } else {
            echo "Error: File approval failed or file not found.";
        }
    }

    // Fetch files pending approval
    $stmt = $conn->prepare("SELECT * FROM files_pending WHERE status = 'pending'");
    $stmt->execute();
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

