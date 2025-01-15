<?php 
session_start();
if (isset($_SESSION['teacher_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Teacher') {
        include "../DB_connection.php";
        include "data/teacher.php";
        include "data/subject.php";
        include "data/grade.php";
        include "data/section.php";
        include "data/class.php";

        $teacher_id = $_SESSION['teacher_id'];
        $teacher = getTeacherById($teacher_id, $conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Menu</title>
    <link rel="stylesheet" href="../css/Accinfo.css">
    <link rel="icon" href="../Admin/logo.png">
    <script src="../js/home_menujsPRO.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

<body>
    <div id="logo">
        <div>
            <p id="titlecard"> SORS System </p>
        </div>
    </div>

    <!-- Main Container for Buttons -->
    <div class="main-container">
        <div class="grid-container">
            <div class="grid-item">
                <button id="button" onclick="redirectToRes3()">
                    <p id="idtext">FILE REPOSITORY</p>
                </button>
            </div>
            <div class="grid-item">
                <button id="button" onclick="redirectToUp3()">
                    <p id="idtext">UPLOAD FILES</p>
                </button>
            </div>
            <div class="grid-item">
                <button id="button" onclick="redirectToApp3()">
                    <p id="idtext">APPROVE FILES</p>
                </button>
            </div>
        </div>
    </div>

    <!-- Account Info Section -->
    <?php if ($teacher != 0) { ?>
    <div class="account-info-container">
        <div class="profile-card">
            <img src="../img/teacher-<?=$teacher['gender']?>.png" alt="Teacher Image">
            <h3>@<?=$teacher['username']?></h3>
            <p>Employee ID: <?=$teacher['employee_number']?></p>
        </div>
        <div class="account-info">
            <?php 
            $credentials = [
                ["name" => "First Name", "details" => $teacher['fname']],
                ["name" => "Last Name", "details" => $teacher['lname']],
                ["name" => "Username", "details" => $teacher['username']],
                ["name" => "Employee Number", "details" => $teacher['employee_number']],
                ["name" => "Address", "details" => $teacher['address']],
                ["name" => "Date of Birth", "details" => $teacher['date_of_birth']],
                ["name" => "Phone Number", "details" => $teacher['phone_number']],
                ["name" => "Qualification", "details" => $teacher['qualification']],
                ["name" => "Email Address", "details" => $teacher['email_address']],
                ["name" => "Gender", "details" => $teacher['gender']],
                ["name" => "Date Joined", "details" => $teacher['date_of_joined']],
                ["name" => "Subjects", "details" => rtrim($s, ', ')],
                ["name" => "Classes", "details" => rtrim($c, ', ')],
            ];
            foreach ($credentials as $credential): ?>
                <div class="credential">
                    <h5><?php echo htmlspecialchars($credential['name']); ?></h5>
                    <p><?php echo htmlspecialchars($credential['details']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php } else { 
        header("Location: logout.php?error=An error occurred");
        exit;
    } ?>

    <script>
        $(document).ready(function(){
            $("#navLinks li:nth-child(1) a").addClass('active');
        });
    </script>
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
