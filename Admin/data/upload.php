<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if a file was uploaded without errors
    if (isset($_FILES["file"]) && $_FILES["file"]["error"] == 0) {
        // Determine the target directory based on user type
        $user_type = $_POST['user_type']; // Get the selected user type
        $target_dir = "uploads/" . $user_type . "/"; // Set the target directory

        // Ensure the target directory exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); // Create the directory if it doesn't exist
        }

        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the file is allowed (you can modify this to allow specific file types)
        $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf");
        if (!in_array($file_type, $allowed_types)) {
            echo "Sorry, only JPG, JPEG, PNG, GIF, and PDF files are allowed.";
        } else {
            // Move the uploaded file to the specified directory
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
                // File upload success, now store information in the database
                $filename = $_FILES["file"]["name"];
                $filesize = $_FILES["file"]["size"];
                $filetype = $_FILES["file"]["type"];

                // Database connection
                $db_host = "localhost";
                $db_user = "root";
                $db_pass = "";
                $db_name = "sors_ex";

                $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Insert the file information into the database
                $sql = "INSERT INTO files (filename, filesize, filetype, user_type) VALUES ('$filename', $filesize, '$filetype', '$user_type')";

                if ($conn->query($sql) === TRUE) {
                    // Success message
                    $success_message = "The file " . basename($_FILES["file"]["name"]) . " has been uploaded to the $user_type directory and the information has been stored in the database.";
                } else {
                    echo "Sorry, there was an error uploading your file and storing information in the database: " . $conn->error;
                }

                $conn->close();
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } else {
        echo "No file was uploaded.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
    <link rel="icon" href="../logo.png"> <!-- Favicon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>File Upload</h2>

    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="user_type" class="form-label">Select User Type</label>
            <select name="user_type" id="user_type" class="form-select" required>
                <option value="Teacher">Teacher</option>
                <option value="Student">Student</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="file" class="form-label">Choose File</label>
            <input type="file" name="file" id="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <?php if (isset($success_message)): ?>
        <div class="alert alert-success mt-3" role="alert">
            <?php echo $success_message; ?>
        </div>
        <div class="card mt-3">
            <div class="card-body text-center">
                <h5 class="card-title">Uploaded File Preview</h5>
                <p class="card-text"><?php echo htmlspecialchars($filename); ?></p>
                <p class="card-text"><?php echo $filesize; ?> bytes</p>
                <p class="card-text"><?php echo $filetype; ?></p>
                <?php if (strpos($filetype, 'image') !== false): ?>
                    <img src="<?php echo $target_file; ?>" class="img-fluid" alt="Image Preview" style="max-height: 150px;">
                <?php elseif (strpos($filetype, 'pdf') !== false): ?>
                    <embed src="<?php echo $target_file; ?>" type="application/pdf" width="100%" height="150px" />
                <?php else: ?>
                    <p>No preview available</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>