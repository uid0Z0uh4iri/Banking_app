<?php
require_once(__DIR__ . '/../../config/database.php');

function getUserInfo($pdo, $user_id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        return $stmt->fetch();
    } catch(PDOException $e) {
        return ['error' => "Erreur lors de la récupération des données: " . $e->getMessage()];
    }
}

// Fonction pour mettre à jour les informations de l'utilisateur
function updateUserInfo($pdo, $userData) {
    try {
        $sql = "UPDATE users SET 
                civility = :civility,
                firstname = :firstname,
                lastname = :lastname,
                birthdate = :birthdate,
                nationality = :nationality,
                email = :email,
                phone = :phone,
                address = :address,
                postal_code = :postal_code,
                city = :city
                WHERE id = :user_id";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute($userData);
        return true;
    } catch(PDOException $e) {
        return ['error' => "Erreur lors de la mise à jour: " . $e->getMessage()];
    }
}
