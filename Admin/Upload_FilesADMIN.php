<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: /SORS_ex/upload_login.php"); // Redirect to login page
    exit;
}

// Database connection variables
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "sors_ex";

// Create a connection
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle first file upload
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        // Get the file path from the input
        $file_path = $_POST['file_path'];

        // Set the target directory
        $target_dir = "uploads/" . $file_path . "/";

        // Ensure the target directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
        }

        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $filesize = $_FILES["file"]["size"]; // Get the file size

        // Move the uploaded file to the specified directory
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // File upload success, now attempt to store information in the database
            $filename = $_FILES["file"]["name"];
            $uploaded_by = $_SESSION['username']; // Get the username of the uploader

            // Insert file information into the `files_pending` table
            $sql = "INSERT INTO files_pending (filename, filesize, filetype, uploaded_by, file_path) 
                    VALUES ('$filename', $filesize, '$file_type', '$uploaded_by', '$file_path')";

            if ($conn->query($sql) === TRUE) {
                echo "The file " . basename($_FILES["file"]["name"]) . " has been uploaded and the information has been stored in the 'files_pending' table.";
            } else {
                echo "Error storing file information in the 'files_pending' table: " . $conn->error;
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "No file was uploaded.";
    }

    // Handle second folder upload
    if (isset($_POST["foldername"]) && !empty($_POST["foldername"])) {
        // Get the folder name from the input
        $foldername = $_POST['foldername'];
        $file_path2 = $_POST['file_path2'];

        // Set the target directory for the folder
        $target_dir2 = "uploads/" . $file_path2 . "/" . $foldername . "/";

        // Ensure the target directory exists
        if (!is_dir($target_dir2)) {
            mkdir($target_dir2, 0777, true); // Create the directory if it doesn't exist
        }

        // Insert folder information into the `files_pending2` table
        $sql2 = "INSERT INTO files_pending2 (foldername, uploaded_by, file_path) 
                 VALUES ('$foldername', '{$_SESSION['username']}', '$file_path2')";

        if ($conn->query($sql2) === TRUE) {
            echo "The folder " . htmlspecialchars($foldername) . " has been created and the information has been stored in the 'files_pending2' table.";
        } else {
            echo "Error storing folder information in the 'files_pending2' table: " . $conn->error;
        }
    } else {
        echo "No folder name was provided.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="icon" href="../logo.png">
 <link rel="stylesheet" href="../css/Upload_FilescssPRO.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="../js/Upload_Filesjs.js"></script>
    <style>
        body {
            background-image: url('./Background.png');
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .container {
            margin-top: 200px; /* Space between the two upload sections */
        }
    </style>
</head>
<body>

<div class="mainHead-container">
    <div class="head-container">
        <div id="logo"><div><p id="titlecard"> SORS System </p></div></div> 
        <div class="head-item"> <a href="index.php" button id="headbutton"><p id="idtext">HOME MENU</p></button></a></div>
        <div class="head-item"> <a href="Repository_FilesADMIN.php" button id="headbutton"><p id="idtext">REPOSITORY FILES</p></button></a></div>
        <div class="head-item"> <a href="Approve_FilesADMIN.php" button id="headbutton"><p id="idtext">APPROVE FILES</p></button></a></div>
    </div>
</div>

<div class="container mt-5">
    <h2 class="text-center">File Upload</h2>

    <div class="card p-4">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="file_path" class="form-label">Enter File Path</label>
                <input type="text" name="file_path" id="file_path" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="file" class="form-label">Choose File</label>
                <input type="file" name="file" id="file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload</button>
        </form>
    </div>

    <div class="container mt-5">
        <h2 class="text-center">Upload Folder</h2>

        <div class="card p-4">
            <form method="POST">
                <div class="mb-3">
                    <label for="file_path2" class="form-label">Enter Folder Path</label>
                    <input type="text" name="file_path2" id="file_path2" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="foldername" class="form-label">Enter Folder Name</label>
                    <input type="text" name="foldername" id="foldername" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Create Folder</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>