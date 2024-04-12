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

// comando che connette al database
$pdo = new PDO($dsn, $user, $pass, $options);

$id = $_GET['id'];
$stmt = $pdo->prepare('DELETE FROM listautenti WHERE id = ?');
$stmt->execute([$id]);

header("Location: /PHP%20Project/PHP%20W1-D2/backOffice.php");