<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../user/login.php');
    exit();
}
require_once "../includes/database.php";

$query = "SELECT * FROM reservations ORDER BY date, time";
$result = mysqli_query($db, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Agenda</title>
</head>
<body>
<h1>Agenda Overzicht</h1>
<table border="1">
    <tr>
        <th>Datum</th>
        <th>Tijd</th>
        <th>Beschrijving</th>
    </tr>
    <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['time']; ?></td>
            <td><?php echo $row['description']; ?></td>
        </tr>
    <?php endwhile; ?>
</table>
</body>
</html>