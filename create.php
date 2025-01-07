<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit();
}
require_once "../includes/database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = mysqli_real_escape_string($db, $_POST['date']);
    $time = mysqli_real_escape_string($db, $_POST['time']);
    $description = mysqli_real_escape_string($db, $_POST['description']);

    if (!empty($date) && !empty($time) && !empty($description)) {
        $query = "INSERT INTO reservations (date, time, description, user_id) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $date, $time, $description, $_SESSION['user']['user_id']);
        mysqli_stmt_execute($stmt);
        header("Location: ../read/index.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Nieuwe Afspraak</title>
</head>
<body>
<h1>Nieuwe Afspraak Maken</h1>
<form method="POST" action="">
    <label for="date">Datum:</label>
    <input type="date" name="date" required><br>

    <label for="time">Tijd:</label>
    <input type="time" name="time" required><br>

    <label for="description">Beschrijving:</label>
    <textarea name="description" required></textarea><br>

    <button type="submit">Opslaan</button>
</form>
</body>
</html>