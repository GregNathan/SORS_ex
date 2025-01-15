<?php 
session_start();
if (isset($_SESSION['student_id']) && isset($_SESSION['role'])) {

    if ($_SESSION['role'] == 'Student') {
       include "../DB_connection.php";
       include "data/student.php";
       include "data/subject.php";
       include "data/grade.php";
       include "data/section.php";

       $student_id = $_SESSION['student_id'];
       $student = getStudentById($student_id, $conn);
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

    <div class="main-container">
        <div class="grid-container">
            <div class="grid-item">
                <button id="button" onclick="redirectToRes2()">
                    <p id="idtext">FILE REPOSITORY</p>
                </button>
            </div>
            <div class="grid-item">
                <button id="button" onclick="redirectToUp2()">
                    <p id="idtext">UPLOAD FILES</p>
                </button>
            </div>
            <?php if ($student != 0) { ?>
            <div class="accouunt-info-container">
                <div class="profile-card">
                    <img src="../img/student-<?=$student['gender']?>.png" alt="Student Image">
                    <div>
                        <h5>@<?=$student['username']?></h5>
                    </div>
                    <?php 
                    // Sample data for credentials (this could come from a database or other source)
                    $credentials = [
                        ["name" => "First Name", "details" => $student['fname']],
                        ["name" => "Last Name", "details" => $student['lname']],
                        ["name" => "Username", "details" => $student['username']],
                        ["name" => "Address", "details" => $student['address']],
                        ["name" => "Date of Birth", "details" => $student['date_of_birth']],
                        ["name" => "Email Address", "details" => $student['email_address']],
                        ["name" => "Gender", "details" => $student['gender']],
                        ["name" => "Date Joined", "details" => $student['date_of_joined']],
                        
                        
                        ["name" => "Parent First Name", "details" => $student['parent_fname']],
                        ["name" => "Parent Last Name", "details" => $student['parent_lname']],
                        ["name" => "Parent Phone Number", "details" => $student['parent_phone_number']],
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
                header("Location: student.php");
                exit;
            } ?>
        </div>
    </div>

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
