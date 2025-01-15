<?php
session_start();
include "DB_connection.php"; // Include your database connection

$sql = "SELECT * FROM files_pending";
$stmt = $conn->prepare($sql);
$stmt->execute();
$pending_files = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Progress</title>
</head>
<body>
    <h1>APPROVED</h1>
