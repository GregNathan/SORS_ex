<?php
session_start();
include "../DB_connection.php";

// Redirect if the user is not an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'Admin') {
    header("Location: /SORS_ex/approve_login.php");
    exit;
}

// Fetch all pending files and folders
$pending_files1 = [];
$pending_files2 = [];

try {
    // Fetch from files_pending (files)
    $sql1 = "SELECT file_id, filename, filesize, uploaded_by FROM files_pending";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->execute();
    $pending_files1 = $stmt1->fetchAll(PDO::FETCH_ASSOC) ?: []; // Default to an empty array if no results

    // Fetch from files_pending2 (folders)
    $sql2 = "SELECT folder_id, foldername, uploaded_by FROM files_pending2";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->execute();
    $pending_files2 = $stmt2->fetchAll(PDO::FETCH_ASSOC) ?: []; // Default to an empty array if no results
} catch (Exception $e) {
    // Handle errors and provide feedback
    die("Error fetching pending files: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Approval</title>
    <link rel="icon" href="../logo.png">
    <link rel="stylesheet" href="../css/Upload_Filescss.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('./Background.png');
            background-size: cover;
            background-position: center;
            color: #fff;
        }

        #logo {
            background-image: url("../Admin/Foldericon.png");
            background-size: 100px;
            background-repeat: no-repeat;
            height: 100px;
            display: flex;
            align-items: center;
        }

        #titlecard {
            color: white;
            padding: 25px;
            font-size: 50px;
            font-family: sans-serif, Verdana;
            font-weight: bolder;
            margin-left: 110px;
            text-shadow: -3px -3px grey;
        }

        .head-container {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .head-item {
            flex: 1;
            text-align: center;
        }

        #headbutton {
            display: inline-block;
            color: white;
            text-decoration: none;
            font-size: 18px;
            padding: 10px 20px;
            border: 1px solid transparent;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        #headbutton:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body>
    <div class="head-container">
        <div id="logo"><p id="titlecard">SORS System</p></div>
        <div class="head-item"><a href="index.php" id="headbutton">HOME MENU</a></div>
        <div class="head-item"><a href="Repository_FilesADMIN.php" id="headbutton">REPOSITORY FILES</a></div>
        <div class="head-item"><a href="Upload_FilesADMIN.php" id="headbutton">UPLOAD</a></div>
    </div>

    <div class="container mt-5">
        <h1>Pending Files for Approval</h1>

        <!-- Section for files_pending (Files) -->
        <h2>Files Pending Approval (File)</h2>
        <table class="table table-bordered table-dark mt-3">
            <thead>
                <tr>
                    <th>File ID</th>
                    <th>Filename</th>
                    <th> Filesize</th>
                    <th>Uploaded By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pending_files1)): ?>
                    <tr>
                        <td colspan="5" class="text-center">No files pending approval.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pending_files1 as $file): ?>
                        <tr>
 <td><?= htmlspecialchars($file['file_id']) ?></td>
                            <td><?= htmlspecialchars($file['filename']) ?></td>
                            <td><?= htmlspecialchars($file['filesize']) ?> bytes</td>
                            <td><?= htmlspecialchars($file['uploaded_by']) ?></td>
                            <td>
                                <a href="approve_fileAD.php?file_id=<?= $file['file_id'] ?>&table=files_pending" class="btn btn-success">Approve</a>
                                <a href="reject_fileAD.php?file_id=<?= $file['file_id'] ?>&table=files_pending" class="btn btn-danger">Reject</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Section for files_pending2 (Folders) -->
        <h2>Folders Pending Approval</h2>
        <table class="table table-bordered table-dark mt-3">
            <thead>
                <tr>
                    <th>Folder ID</th>
                    <th>Folder Name</th>
                    <th>Uploaded By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pending_files2)): ?>
                    <tr>
                        <td colspan="4" class="text-center">No folders pending approval.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pending_files2 as $folder): ?>
                        <tr>
                            <td><?= htmlspecialchars($folder['folder_id']) ?></td>
                            <td><?= htmlspecialchars($folder['foldername']) ?></td>
                            <td><?= htmlspecialchars($folder['uploaded_by']) ?></td>
                            <td>
                                <a href="approve_fileAD.php?folder_id=<?= $folder['folder_id'] ?>" class="btn btn-success">Approve</a>
                                <a href="reject_filerAD.php?folder_id=<?= $folder['folder_id'] ?>" class="btn btn-danger">Reject</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
