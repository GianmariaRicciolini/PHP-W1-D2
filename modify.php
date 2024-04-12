<?php
// Connessione al database e recupero dei dati dell'utente
$host = 'localhost';
$db   = 'ifoa_firstdatabase';
$user = 'root';
$pass = '';

$dsn = "mysql:host=$host;dbname=$db";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Connessione al database
$pdo = new PDO($dsn, $user, $pass, $options);

$id = $_GET['id'];

$errors = [];
// Verifica se il modulo è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Esegui la validazione dei dati
    $username = $_POST['Username'];
    $email = $_POST['Email'];
    $age = $_POST['age'];
    $password = $_POST['Password'];

    // Validazione dei dati
    if (empty($username)) {
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
        // Se non ci sono errori, esegui l'aggiornamento dei dati dell'utente nel database
        $stmt = $pdo->prepare('UPDATE listautenti SET Username = :Username, Email = :Email, age = :age, Password = :Password  WHERE id = :id');
        $stmt->execute([
            'id' => $id,
            'Username' => $username,
            'Email' => $email,
            'age' => $age,
            'Password' => $password
        ]);

        // Reindirizza l'utente al backoffice dopo l'aggiornamento
        header("Location: backOffice.php");
        exit;
    }
}

// Esegui la query per ottenere i dati dell'utente con l'ID specificato
$stmt = $pdo->prepare('SELECT * FROM listautenti WHERE id = :id');
$stmt->execute(['id' => $id]);
$user = $stmt->fetch();

// Verifica se l'utente è stato trovato
if (!$user) {
    echo "Utente non trovato";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Modify User</h2>
            <form action="" method="post">
    <input type="hidden" name="id" value="<?= $id ?>">
    <div class="mb-3">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="Username" value="<?= $user['Username'] ?>" required>
</div>
<div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="Email" value="<?= $user['Email'] ?>" required>
</div>
<div class="mb-3">
    <label for="age" class="form-label">Age</label>
    <input type="number" class="form-control" id="age" name="age" value="<?= $user['age'] ?>" required>
</div>
<div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="Password" value="<?= $user['Password'] ?>" required>
</div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>