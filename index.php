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

$errors = [];

// Inizializza la connessione al database
$pdo = new PDO($dsn, $user, $pass, $options);

// SELECT DI TUTTE LE RIGHE
$stmt = $pdo->query('SELECT * FROM listautenti');

?>

<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forms</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <div class="text-end pe-5 me-5">
        <a class="btn btn-secondary mt-5" href="./backOffice.php">BackOffice</a>
    </div>

<div class="container mt-4">
    <div class="row">
        <div class="col-6">
            <form action="" method="post" class="pt-5 d-flex flex-column" novalidate>
                <div class="row mb-3">
                    <label class="col-4 pt-3" for="username">Username</label>
                    <div class="col-8">
                        <input class="mt-2 w-100" type="text" name="username" id="username" placeholder="Username">
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label class="col-4 pt-3" for="email">Email</label>
                    <div class="col-8">
                        <input class="mt-2 w-100" type="email" name="email" id="email" placeholder="example@email.com" value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>">
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label class="col-4 pt-3" for="age">Età</label>
                    <div class="col-8">
                        <input class="mt-2 w-25" type="number" name="age" id="age">
                    </div>
                </div>
        
                <div class="row mb-3">
                    <label class="col-4 pt-3" for="password">Password</label>
                    <div class="col-8">
                        <input type="password" name="password" id="password" placeholder="A secure password" class="form-control mt-2 w-100">
                    </div>
                </div>
        
                <button type="submit" class="btn btn-primary w-25 mt-4">Invia</button>
            </form>
        </div>
        <div class="col-6">
            <?php
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
                    // Inserisci i dati nel database
                    $stmt = $pdo->prepare("INSERT INTO listautenti (username, email, age, password) VALUES (?, ?, ?, ?)");
                    $stmt->execute([$name, $email, $age, $password]);
                    
                    // Reindirizza alla pagina di successo
                    header('Location: success.php');
                    exit;
                }
            }
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>