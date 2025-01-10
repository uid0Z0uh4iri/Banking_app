<?php
require_once(__DIR__ . '/../../config/database.php');

function handleProfilePicUpload($pdo, $file, $user_id) {
    // Vérifier si le fichier est une image
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowed_types)) {
        return ['error' => "Seuls les fichiers JPG, PNG et GIF sont autorisés"];
    }

    // Vérifier la taille du fichier (max 5MB)
    if ($file['size'] > 5 * 1024 * 1024) {
        return ['error' => "La taille du fichier ne doit pas dépasser 5MB"];
    }

    // Créer le dossier images s'il n'existe pas
    $upload_dir = __DIR__ . '/../../images/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Générer un nom de fichier unique
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = 'profile_' . $user_id . '_' . time() . '.' . $extension;
    $target_path = $upload_dir . $filename;

    if (move_uploaded_file($file['tmp_name'], $target_path)) {
        try {
            $stmt = $pdo->prepare("UPDATE users SET profile_pic = ? WHERE id = ?");
            $stmt->execute([$filename, $user_id]);
            return ['success' => "Photo de profil mise à jour avec succès"];
        } catch(PDOException $e) {
            return ['error' => "Erreur lors de la mise à jour de la photo: " . $e->getMessage()];
        }
    }
    
    return ['error' => "Erreur lors du téléchargement du fichier"];
}
