<?php
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

// Query per selezionare tutti i record dalla tabella listautenti
$stmt = $pdo->query('SELECT * FROM listautenti');

// Estrai i risultati come array associativo
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Backoffice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <a class="btn btn-warning ms-5 mt-5" href="./Index.php">Back</a>


<div class="container mt-4 pt-5">
    <div class="row">
        <?php foreach ($users as $user): ?>
            <div class="col-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Username: <?= $user['Username'] ?></h5>
                        <p class="card-text">Email: <?= $user['Email'] ?></p>
                        <p class="card-text">Età: <?= $user['age'] ?></p>
                        <p class="card-text">Password: <?= $user['Password'] ?></p>
                        <a class="btn btn-danger" href="./delete.php?id=<?= $user['id'] ?>">Delete</a>
                        <a class="btn btn-primary" href="./modify.php?id=<?= $user['id'] ?>">Modify</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>