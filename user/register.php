<?php

if (isset($_POST['submit'])) {
    require_once "includes/database.php";

    // Get form data
    $firstName = mysqli_real_escape_string($db, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($db, $_POST['lastName']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $errors = [];
    if ($firstName === '') {
        $errors['firstName'] = 'First name cannot be empty';
    }
    if ($lastName === '') {
        $errors['lastName'] = 'Last name cannot be empty';
    }
    if ($email === '') {
        $errors['email'] = 'Email cannot be empty';
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    if ($password === '') {
        $errors['password'] = 'Password cannot be empty';
    }

    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, "ssss", $firstName, $lastName, $email, $hashedPassword);

        if (mysqli_stmt_execute($stmt)) {
            header('Location: secure.php');
            exit;
        } else {
            $errors['database'] = 'Something went wrong with the database: ' . mysqli_error($db);
        }

        mysqli_stmt_close($stmt);
    }
}


?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="CSS/register.css">
    <title>Registreren</title>
</head>
<body>

<section class="section">
    <div class="container content">
        <h2 class="title">Register With Email</h2>

        <section class="columns">
            <form class="column is-6" action="" method="post">

                <!-- First name -->
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="firstName">First name</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" id="firstName" type="text" name="firstName" value="<?= $name ?? '' ?>" />
                                <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['firstName'] ?? '' ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Last name -->
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="lastName">Last name</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" id="lastName" type="text" name="lastName" value="<?= $lastName ?? '' ?>" />
                                <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['lastName'] ?? '' ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Email -->
                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="email">Email</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" id="email" type="text" name="email" value="<?= $email ?? '' ?>" />
                                <span class="icon is-small is-left"><i class="fas fa-envelope"></i></span>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['email'] ?? '' ?>
                            </p>
                        </div>
                    </div>
                </div>

                <div class="field is-horizontal">
                    <div class="field-label is-normal">
                        <label class="label" for="password">Password</label>
                    </div>
                    <div class="field-body">
                        <div class="field">
                            <div class="control has-icons-left">
                                <input class="input" id="password" type="password" name="password"/>
                                <span class="icon is-small is-left"><i class="fas fa-lock"></i></span>
                            </div>
                            <p class="help is-danger">
                                <?= $errors['password'] ?? '' ?>
                            </p>
                        </div>
                    </div>
                </div>


                <div class="field is-horizontal">
                    <div class="field-label is-normal"></div>
                    <div class="field-body">
                        <button class="button is-link is-fullwidth" type="submit" name="submit">Register</button>
                    </div>
                    <a href="../ProjectCLE2/login.php">log in</a>
                </div>

            </form>
        </section>

    </div>
</section>
</body>
</html>
