<?php
session_start();
include "DB_connection.php"; // Include your database connection

$sql = "SELECT * FROM files_pending";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pending_files = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pending Files</title>
</head>
<body>
    <h1>Pending Files for Approval</h1>
    <table>
        <tr>
            <th>File ID</th>
            <th>Filename</th>
            <th>Filesize</th>
            <th>Uploaded By</th>
            <th>Action</th>
        </tr>
        <?php foreach ($pending_files as $file): ?>
        <tr>
            <td><?= $file['file_id'] ?></td>
            <td><?= $file['filename'] ?></td>
            <td><?= $file['filesize'] ?> bytes</td>
            <td><?= $file['uploaded_by'] ?></td>
            <td>
                <a href="approve_file.php?file_id=<?= $file['file_id'] ?>">Approve</a>
                <a href="reject_file.php?file_id=<?= $file['file_id'] ?>">Reject</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>