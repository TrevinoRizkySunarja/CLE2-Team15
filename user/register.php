<?php
session_start();

// Databaseverbinding
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = 'martinez_zorg';
require_once '../includes/database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    if (!empty($email) && !empty($_POST['password'])) {
        $query = "INSERT INTO users (email, password, is_admin) VALUES (?, ?, 0)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "ss", $email, $password);
        mysqli_stmt_execute($stmt);
        header("Location: login.php");
        exit;
    } else {
        $errors['fields'] = "Alle velden zijn verplicht.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registreren</title>
</head>
<body>
<h1>Registreren</h1>
<form method="POST" action="">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="password">Wachtwoord:</label>
    <input type="password" name="password" required><br>

    <button type="submit">Registreren</button>
</form>
<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <?php foreach ($errors as $error): ?>
            <p><?php echo $error; ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
</body>
</html>