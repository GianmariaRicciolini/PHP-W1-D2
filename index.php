<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<?php
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $password = $_POST['password'];

    // Validazione dei dati
    if (empty($name)) {
        $errors['username'] = 'Inserisci un username';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Email non valida';
    }
    
    if ($age < 18) {
        $errors['age'] = 'Devi avere almeno 18 anni per registrarti';
    }

    if (strlen($password) < 8) {
        $errors['password'] = 'Password troppo corta';
    }

    // Se ci sono errori, visualizza il form con gli errori
    if (!empty($errors)) {
        echo '<div class="container mt-4 pt-5">';
        echo '<div class="alert alert-danger" role="alert">';
        echo '<h4 class="alert-heading">Ci sono errori nel modulo:</h4>';
        echo '<ul>';
        foreach ($errors as $error) {
            echo '<li>' . $error . '</li>';
        }
        echo '</ul>';
        echo '</div>';
        echo '</div>';
    } else {
        // Altrimenti, procedi con l'elaborazione dei dati
        // Salvataggio dei dati nel database, invio di email, ecc.

        // Reindirizzamento alla pagina di successo
        header('Location: success.php');
        exit;
    }
}
?>

<div class="container mt-4">
    <form action="" method="post" class="pt-5" novalidate>
        <label for="username">Username</label>
        <input class="mt-2" type="text" name="username" id="username" placeholder="Username">
        <br>

        <label for="email">Email</label>
        <input class="mt-2" type="email" name="email" id="email" placeholder="example@email.com" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
        <br>

        <label for="age">Età</label>
        <input class="mt-2" type="number" name="age" id="age">
        <br>

        <label for="password">Password</label>
        <input type="password" name="password" id="password" placeholder="A secure password" class="form-control w-25 mt-2">
        <br>

        <button type="submit" class="btn btn-primary">Invia</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>