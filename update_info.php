<?php
require_once('config/db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: auth.php');
    exit();
}

$db = new Database();
$pdo = $db->connect();

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération des données du formulaire
    $civility = $_POST['civility'] ?? '';
    $lastname = $_POST['nom'] ?? '';
    $firstname = $_POST['prenom'] ?? '';
    $birthdate = $_POST['date_naissance'] ?? '';
    $nationality = $_POST['nationalite'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['telephone'] ?? '';
    $address = $_POST['adresse'] ?? '';
    $postal_code = $_POST['code_postal'] ?? '';
    $city = $_POST['ville'] ?? '';
    
    $user_id = $_SESSION['user_id'];

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
                city = :city,
                is_first_login = 0
                WHERE id = :user_id";
                
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'civility' => $civility,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'birthdate' => $birthdate,
            'nationality' => $nationality,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'postal_code' => $postal_code,
            'city' => $city,
            'user_id' => $user_id
        ]);

        $_SESSION['success_message'] = "Vos informations ont été mises à jour avec succès!";
        header('Location: client/profil.php');
        exit();
    } catch(PDOException $e) {
        $_SESSION['error_message'] = "Erreur lors de la mise à jour: " . $e->getMessage();
    }
}

// Récupération des données actuelles de l'utilisateur
try {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
} catch(PDOException $e) {
    $_SESSION['error_message'] = "Erreur lors de la récupération des données: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mise à jour des informations - BanKa2KA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-2xl w-full bg-white rounded-lg shadow p-8 m-4">
            <h1 class="text-2xl font-bold text-center text-gray-800 mb-8">Complétez vos informations personnelles</h1>
            
            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php 
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Civilité</label>
                        <select name="civility" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                            <option value="M." <?php echo (isset($user['civility']) && $user['civility'] == 'M.') ? 'selected' : ''; ?>>M.</option>
                            <option value="Mme" <?php echo (isset($user['civility']) && $user['civility'] == 'Mme') ? 'selected' : ''; ?>>Mme</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                        <input type="text" name="nom" value="<?php echo htmlspecialchars($user['lastname'] ?? ''); ?>" 
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" name="prenom" value="<?php echo htmlspecialchars($user['firstname'] ?? ''); ?>" 
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                        <input type="date" name="date_naissance" value="<?php echo htmlspecialchars($user['birthdate'] ?? ''); ?>" 
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nationalité</label>
                        <select name="nationalite" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                            <option value="Française" <?php echo (isset($user['nationality']) && $user['nationality'] == 'Française') ? 'selected' : ''; ?>>Française</option>
                            <option value="Autre" <?php echo (isset($user['nationality']) && $user['nationality'] == 'Autre') ? 'selected' : ''; ?>>Autre</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>" 
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="tel" name="telephone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>" 
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" name="adresse" value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>" 
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Code postal</label>
                        <input type="text" name="code_postal" value="<?php echo htmlspecialchars($user['postal_code'] ?? ''); ?>" 
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ville</label>
                        <input type="text" name="ville" value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>" 
                               class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2" required>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Enregistrer mes informations
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 