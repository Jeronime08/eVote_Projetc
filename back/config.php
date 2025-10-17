




<?php
try {
    $host = "localhost";
    $dbname = "evote_db";
    $username = "root";
    $password = "";

    // Connexion avec $pdo, comme dans ton ancien code
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (\Throwable $th) {
    die("Erreur de connexion à la base de données : " . $th->getMessage());
}
?>