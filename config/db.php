<?php
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=banque;charset=utf8mb4",
        "root",  // votre nom d'utilisateur MySQL
        "",      // votre mot de passe MySQL
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}