<?php
session_start();
require_once '../includes/database.php';

$errors = [];

if (isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = $_POST['password'];

    // Validatie
    if (empty($email) || empty($password)) {
        $errors['fields'] = "Vul alle velden in.";
    } else {
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                header("Location: ../read/index.php");
                exit;
            } else {
                $errors['login'] = "Ongeldig wachtwoord.";
            }
        } else {
            $errors['login'] = "Gebruiker niet gevonden.";
        }
        mysqli_stmt_close($stmt);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
<h1>Login</h1>
<form method="POST" action="">
    <label for="email">Email:</label>
    <input type="email" name="email" required><br>

    <label for="password">Wachtwoord:</label>
    <input type="password" name="password" required><br>

    <button type="submit" name="submit">Login</button>
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