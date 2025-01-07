<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['is_admin'] != 1) {
    header('Location: ../user/login.php');
    exit();
}
require_once "../includes/database.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];
$query = "SELECT * FROM reservations WHERE id = ?";
$stmt = mysqli_prepare($db, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$reservation = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = mysqli_real_escape_string($db, $_POST['date']);
    $time = mysqli_real_escape_string($db, $_POST['time']);
    $description = mysqli_real_escape_string($db, $_POST['description']);

    if (!empty($date) && !empty($time) && !empty($description)) {
        $updateQuery = "UPDATE reservations SET date = ?, time = ?, description = ? WHERE id = ?";
        $updateStmt = mysqli_prepare($db, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, "sssi", $date, $time, $description, $id);
        mysqli_stmt_execute($updateStmt);
        header("Location: details.php?id=$id");
        exit();
    }
}
?>