<?php 
session_start();
if (isset($_SESSION['admin_id']) && 
    isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Admin') {
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Menu</title>
    <link rel="stylesheet" href="../css/home_menucssADMIN">
    <script src="../js/home_menujsPRO.js"></script>
    <link rel="icon" href="../Admin/logo.png">
</head>

<body>

    <div id="logo">
        <div>
            <p id="titlecard"> SORS System </p>
        </div>
    </div>

<div class="main-container">
        <div class="grid-container">
            <div class="grid-item">
                <button id="button" onclick="redirectToRes1()"><p id="idtext">FILE REPOSITORY</p></button>
            </div>
            <div class="grid-item">
                <button id="button" onclick="redirectToUp1()"><p id="idtext">UPLOAD FILES</p></button>
            </div>
            <div class="grid-item">
                <button id="button" onclick="redirectToApp1()"><p id="idtext">APPROVE FILES</p></button>
            </div>
        </div>

        <div class="grid-container">
            <div class="grid-item">
                <button id="button" onclick="window.location.href ='teacher.php'"><p id="idtext">TEACHERS</p></button>
            </div>
            <div class="grid-item">
                <button id="button" onclick="redirectStudent()"><p id="idtext">STUDENTS</p></button>
            </div>
        </div>
</div>


</div>
</body>
</html>

<?php 
    } else {
        header("Location: ../login.php");
        exit;
    } 
} else {
    header("Location: ../login.php");
    exit;
} 
?>