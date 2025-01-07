
<?php
session_start();

// Databaseverbinding
$host = '127.0.0.1';
$username = 'root';
$password = '';
$database = '';

$db = mysqli_connect($host, $username, $password, $database)
or die('Error: ' . mysqli_connect_error());

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($db, $_POST['username']);
    $inputPassword = $_POST['password'];

    if (empty($email) || empty($inputPassword)) {
        $errors[] = "Vul zowel je gebruikersnaam als wachtwoord in!";
    }

    if (empty($errors)) {
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($db, $query);

        if (!$result) {
            die('Error ' . mysqli_error($db) . ' met query ' . $query);
        }

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            if (password_verify($inputPassword, $row['password'])) {
                $_SESSION['loggedIn'] = true;
                $_SESSION['email'] = $row['email'];

                header("Location: secure.php");
                exit;
            } else {
                $errors[] = "Ongeldig wachtwoord!";
            }
        } else {
            $errors[] = "Geen gebruiker gevonden met dit e-mailadres!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="CSS/login.css">
</head>
<body>
<h1>Inloggen</h1>

<form method="post" action="login.php">
    <label for="username">Email:</label>
    <input type="email" id="username" name="username" required>
    <br>
    <label for="password">Wachtwoord:</label>
    <input type="password" id="password" name="password" required>
    <br>
    <button type="submit">Inloggen</button>
    <div>
        <a href="register.php">Account aanmaken</a>
    </div>
</form>

<?php if (!empty($errors)): ?>
    <div style="color: red;">
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

</body>
</html>