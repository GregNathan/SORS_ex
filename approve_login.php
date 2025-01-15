<?php
session_start();
include "./DB_connection.php"; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role']; 

    // Validate username and password
    if (empty($username) || empty($password)) {
        $error = "Username and password are required.";
    } else {
        if ($role == 'Admin') {
            $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        } else {
            $stmt = $conn->prepare("SELECT * FROM teachers WHERE username = ?");
        }
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $username; // Set session variable
            $_SESSION['role'] = $role; // Set user role
            $_SESSION['user_id'] = $user['id']; // Assuming 'id' is the primary key
            
            // Redirect to the appropriate upload page based on role
            if ($role == 'Admin') {
                header("Location: /SORS_ex/Admin/Approve_FilesADMIN.php"); // Redirect to student upload page
            } else {
                header("Location: /SORS_ex/Teacher/Approve_FilesTEACHER.php"); // Redirect to teacher upload page
            }
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <form method="POST" action="">
        <select name="role" required>
            <option value="Admin">Admin</option>
            <option value="Teacher">Teacher</option>
        </select>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</body>
</html