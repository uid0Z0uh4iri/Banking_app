<?php
require_once(__DIR__ . '/../../config/database.php');
require_once(__DIR__ . '/user_info.php');

function handlePasswordUpdate($pdo, $current_password, $new_password, $confirm_password, $user_id) {
    try {
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!password_verify($current_password, $user['password'])) {
            return ['error' => "Le mot de passe actuel est incorrect"];
        } 
        if ($new_password !== $confirm_password) {
            return ['error' => "Les nouveaux mots de passe ne correspondent pas"];
        }
        if (strlen($new_password) < 8) {
            return ['error' => "Le nouveau mot de passe doit contenir au moins 8 caractères"];
        }

        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
        $stmt->execute([
            'password' => $hashed_password,
            'user_id' => $user_id
        ]);

        return ['success' => "Votre mot de passe a été mis à jour avec succès"];
    } catch(PDOException $e) {
        return ['error' => "Erreur lors de la mise à jour du mot de passe: " . $e->getMessage()];
    }
}

function handleProfileUpdate($pdo, $postData, $user_id) {
    try {
        error_log('Début handleProfileUpdate');
        error_log('Post Data: ' . print_r($postData, true));
        error_log('User ID: ' . $user_id);

        $sql = "UPDATE users SET 
                civility = :civility,
                lastname = :lastname,
                firstname = :firstname,
                birthdate = :birthdate,
                nationality = :nationality,
                email = :email,
                phone = :phone,
                address = :address,
                postal_code = :postal_code,
                city = :city
                WHERE id = :user_id";
                
        $stmt = $pdo->prepare($sql);
        error_log('SQL préparé: ' . $sql);
        
        // Mapping des données du formulaire avec les champs de la base de données
        $params = [
            'civility' => $postData['civility'],
            'lastname' => $postData['nom'],
            'firstname' => $postData['prenom'],
            'birthdate' => $postData['date_naissance'],
            'nationality' => $postData['nationalite'],
            'email' => $postData['email'],
            'phone' => $postData['telephone'],
            'address' => $postData['adresse'],
            'postal_code' => $postData['code_postal'],
            'city' => $postData['ville'],
            'user_id' => $user_id
        ];
        error_log('Paramètres: ' . print_r($params, true));

        // Exécution de la requête avec les paramètres
        $result = $stmt->execute($params);
        error_log('Résultat de l\'exécution: ' . ($result ? 'true' : 'false'));
        
        if ($result) {
            error_log('Mise à jour réussie');
            return ['success' => "Les informations ont été mises à jour avec succès!"];
        } else {
            error_log('Erreur lors de la mise à jour');
            error_log('PDO Error Info: ' . print_r($stmt->errorInfo(), true));
            return ['error' => "Erreur lors de la mise à jour des informations"];
        }
    } catch(PDOException $e) {
        error_log('Exception PDO: ' . $e->getMessage());
        return ['error' => "Erreur lors de la mise à jour: " . $e->getMessage()];
    }
}
