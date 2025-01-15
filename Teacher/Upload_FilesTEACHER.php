<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: /SORS_ex/upload_login.php"); // Redirect to login page
    exit;
}

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "sors_ex";

try {
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
        $filename = $_FILES["file"]["name"];
        $filesize = $_FILES["file"]["size"];
        $filetype = $_FILES["file"]["type"];
        $uploaded_by = $_SESSION['username']; // Get the username from the session

        // Check if the uploaded_by variable is set
        if (empty($uploaded_by)) {
            echo "Error: User is not logged in.";
            exit;
        }

        // Move the uploaded file to a designated folder
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Move the uploaded file
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_dir . $filename)) {
            // Insert file information into files_pending table
            $sql = "INSERT INTO files_pending (filename, filesize, filetype, uploaded_by) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$filename, $filesize, $filetype, $uploaded_by]);

            // Clear the session after successful upload
            session_unset();
            session_destroy();

            // Redirect to success page
            header("Location: upload_success.php");
            exit;
        } else {
            echo "Error: There was an error uploading your file.";
        }
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>

<link rel="icon" href="../logo.png">
<link rel="stylesheet" href="../css/Upload_FilescssPRO.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="../js/Upload_Filesjs.js"> </script>
<style>
 body {
            background-image: url('./Background.png'); /* Set the background image */
            background-size: cover; /* Cover the entire page */
            background-position: center; /* Center the background image */
            color: #fff; /* Set text color to white for better contrast */
        }
      
        #logo {
            background-image: url("../Admin/Foldericon.png"); /* Path to your folder icon */
            background-size: 100px; /* Size of the icon */
            background-repeat: no-repeat; /* Prevent the image from repeating */
            background-position-x: 22px; /* Horizontal position of the icon */
            background-position-y: 10px; /* Vertical position of the icon */
            height: 100px; /* Set a height for the logo area */
            display: flex; /* Use flexbox for alignment */
            align-items: center; /* Center vertically */
        }

        #titlecard {
          color: white;
    padding: 25px;
    font-size: 50px;
    font-family: sans-serif, Verdana; 
    font-weight: bolder;
    margin-top: 50px;
    margin-left: 110px;
    text-shadow: -3px -3px grey;
        }
        

        .folder-icon {
            position: absolute; /* Position it absolutely */
            top: 20px; /* Adjust top position */
            left: 20px; /* Adjust left position */
            width: 50px; /* Set width of the icon */
            height: auto; /* Maintain aspect ratio */
        }

        .main-container {
    display: flex; /* Use flexbox for layout */
    justify-content: center; /* Center the grid items */
    align-items: center; /* Center items vertically */
    padding: 20px; /* Add padding around the container */
}

.grid-container {
    display: grid; /* Use grid layout */
    grid-template-columns: repeat(3, 1fr); /* Three equal columns */
    gap: 20px; /* Space between grid items */
}

.grid-item {
    background-color: #007BFF; /* Background color for the grid items */
    border-radius: 25px; /* Rounded corners for oval shape */
    padding: 20px; /* Padding inside the grid items */
    text-align: center; /* Center text inside the grid items */
    transition: background-color 0.3s; /* Smooth transition for hover effect */
}

.grid-item:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

#button {
    display: block; /* Make the link a block element */
    color: white; /* Text color */
    text-decoration: none; /* Remove underline */
    font-size: 18px; /* Font size for the text */
}

.head-container {
        display: flex; /* Use flexbox for layout */
        justify-content: space-around; /* Space buttons evenly */
        align-items: center; /* Center items vertically */
        padding: 10px; /* Add padding around the container */
        background-color: rgba(0, 0, 0, 0.5); /* Optional: Add background for better visibility */
    }

    .head-item {
        flex: 1; /* Allow buttons to grow equally */
        text-align: center; /* Center text inside the buttons */
    }

    #headbutton {
        display: inline-block; /* Make the link a block element */
        color: white; /* Text color */
        text-decoration: none; /* Remove underline */
        font-size: 18px; /* Font size for the text */
        padding: 10px 20px; /* Add padding for better click area */
        border: 1px solid transparent; /* Add border for better visibility */
        border-radius: 5px; /* Rounded corners */
        transition: background-color 0.3s; /* Smooth transition for hover effect */
    }

    #headbutton:hover {
        background-color: rgba(255, 255, 255, 0.2); /* Change background on hover */
    }
</style>
</head>
<body>

<div class="mainHead-container">
<div class="head-container">
    <div id="logo"><div><p id="titlecard"> SORS System </p></div></div> 
        <div class="head-item"> <a href="index.php" button id="headbutton"><p id="idtext">HOME MENU</p></button></a></div>
        <div class="head-item"> <a href="Repository_FilesTEACHER.php" button id="headbutton"><p id="idtext">REPOSITORY FILES</p></button></a></div>
        <div class="head-item"> <a href="Approve_FilesTEACHER.php" button id="headbutton"><p id="idtext">APPROVE FILES</p></button></a></div>
    </div>
    </div>


    <div class="container mt-5">
        <h2 class="text-center">File Upload</h2>

        <div class="card p-4">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="file" class="form-label">Choose File</label>
                    <input type="file" name="file" id="file" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
        </div>

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