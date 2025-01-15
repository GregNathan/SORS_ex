<?php
// Database connection details
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "sors_db";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize search variable
$search = '';
if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);
}

// Fetch the uploaded files from the database with search functionality
$sql = "SELECT * FROM files WHERE filename LIKE '%$search%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Repository</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="icon" href="../logo.png">
    <style>
        body {
            background-image: url('../Background.png'); /* Set the background image */
            background-size: cover; /* Cover the entire page */
            background-position: center; /* Center the background image */
            color: #fff; /* Set text color to white for better contrast */
        }
        .container {
            background-color: rgba(0, 0, 0, 0.7); /* Semi-transparent background for the container */
            border-radius: 10px; /* Rounded corners */
            padding: 20px; /* Padding inside the container */
            margin-top: 50px; /* Margin from the top */
        }
        .folder-icon {
            position: absolute; /* Position it absolutely */
            top: 20px; /* Adjust top position */
            left: 20px; /* Adjust left position */
            width: 50px; /* Set width of the icon */
            height: auto; /* Maintain aspect ratio */
        }
    </style>
</head>
<body>

    <!-- Folder Icon -->
    <img src="../Foldericon.png" alt="Folder Icon" class="folder-icon">

    <div class="container mt-5">
        <h2>REPOSITORY</h2>
        
        <!-- Search Form -->
        <form method="POST" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search files..." value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-outline-secondary" type="submit">Search</button>
            </div>
        </form>

        <div class="row">
            <?php
            // Display the uploaded files with previews
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $file_path = "uploads/" . $row['filename'];
                    $file_type = $row['filetype'];
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <h5 class="card-title"><?php echo $row['filename']; ?></h5>
                                <p class="card-text"><?php echo $row['filesize']; ?> bytes</p>
                                <p class="card-text"><?php echo $file_type; ?></p>
                                <?php if (strpos($file_type, 'image') !== false): ?>
                                    <img src="<?php echo $file_path; ?>" class="img-fluid" alt="Image Preview" style="max-height: 150px;">
                                <?php elseif (strpos($file_type, 'pdf') !== false): ?>
                                    <embed src="<?php echo $file_path; ?>" type="application/pdf" width="100%" height="150px" />
                                <?php else: ?>
                                    <p>No preview available</p>
                                <?php endif; ?>
                                <a href="<?php echo $file_path; ?>" class="btn btn-primary mt-2" download>Download</a>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                ?>
                <div class="col-12">
                    <div class="alert alert-warning" role="alert">
                        No files uploaded yet.
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</ body>

    <?php
    $conn->close();
    ?>
</html>