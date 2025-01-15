<?php
// Database connection details
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "sors_ex";

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
$sql = "SELECT * FROM files_final WHERE name LIKE '%$search%'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repository</title>
</head>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="icon" href="../logo.png">
<link rel="stylesheet" href="../css/Repository_Filescss.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="../js/Repository_Filesjs.js"> </script>
<style>
body {
    background-image: url('../img/BackgroundPRO.png'); /* Set the background image */
    background-size: cover; /* Cover the entire page */
    background-position: center; /* Center the background image */
    color: #fff; /* Set text color to white for better contrast */
}

#logo {
    background-image: url("../img/FoldericonPRO.png"); /* Path to your folder icon */
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
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 columns with equal width */
    gap: 10px; /* Optional: Adjust the spacing between grid items */
    width: 100%; /* Optional: Adjust container width */
    margin: 0 auto; /* Center the grid horizontally */
}

.grid-item {
    background-color: #007BFF; /* Background color for the grid items */
    border-radius: 25px; /* Rounded corners for oval shape */
    padding: 20px; /* Padding inside the grid items */
    text-align: center; /* Center text inside the grid items */
    transition: background-color 0.3s; /* Smooth transition for hover effect */
    width: 100%; /* Full width for the grid items */
    height: 200px; /* Fixed height for the grid items */
    overflow: hidden; /* Hide overflow content */
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
        <div class="head-item"> <a href="Approve_FilesADMIN.php" button id="headbutton"><p id="idtext">APPROVE</p></button></a></div>
        <div class="head-item"> <a href="Upload_FilesADMIN.php" button id="headbutton"><p id="idtext">UPLOAD</p></button></a></div>
    </div>
    </div>

    <div class="container mt-5">
    <h2>REPOSITORY</h2>
    
    <!-- Search Form -->
    <form method="POST" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search files..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-outline-secondary" type="submit">Search</button>
        </div>
    </form>

    <?php
    $rows = [];
    $groupedRows = []; // Initialize the grouped rows array

    // Fetch all rows from the result
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }
    }

    // Create a map of names to rows for faster lookups
    $nameMap = [];
    foreach ($rows as $row) {
        $nameMap[$row['name']] = $row;
    }

    // Group rows by matching `filepath` and `name`
    foreach ($rows as $row) {
        $filePath = $row['file_path']; // Ensure correct column name
        if (isset($nameMap[$filePath])) {
            $groupedRows[$filePath][] = $row;
        }
    }

    // Debugging: Uncomment to view grouped rows
    echo '<pre>' . print_r($groupedRows, true) . '</pre>';
?>

<!-- WORK ON PROGRESS -->
    <div class="grid-container">
        <?php
         $folders = [];
         $files = [];
         $groupedRows = [];

        // Display the uploaded files without previews
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $file_path = "uploads/" . $row['name'];
                ?>

                <?php
                if ($result->num_rows > 0) {
                    // Loop through the rows to categorize folders and files
                    while ($row = $result->fetch_assoc()) {
                        if ($row['viewtype'] == 'folder') {
                            $folders[] = $row;
                        } elseif ($row['viewtype'] == 'file') {
                            $files[] = $row;
                        }
                    }
            
                    // Display folders first
                    foreach ($folders as $row) {
                        ?>
                        <div class="grid-item">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                        </div>
                        <?php
                    }
            
                    // Display files next
                    foreach ($files as $row) {
                        $file_path = "uploads/" . basename($row['name']);
                        ?>
                        <div class="grid-item">
                            <h5 class="card-title"><?php echo htmlspecialchars($row['name']); ?></h5>
                            <p class="card-text"><?php echo $row['filesize']; ?> bytes</p>
                            <p class="card-text"><?php echo $row['filetype']; ?></p>
                            <a href="<?php echo htmlspecialchars($file_path); ?>" class="btn btn-primary mt-2" download>Download</a>
                        </div>
                        <?php
                    }
                } else {
                    // If no rows, show an alert
                    ?>
                    <div class="col-12">
                        <div class="alert alert-warning" role="alert">
                            No files uploaded yet.
                        </div>
                    </div>
                    <?php
                }}}
                ?>
                
        
    </div>


<?php
$conn->close();
?>
</body>
</html>