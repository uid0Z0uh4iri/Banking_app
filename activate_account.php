<?php
require_once('config/database.php');
session_start();

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
        // Démarrer la transaction
        $pdo->beginTransaction();

        // Mise à jour des informations utilisateur
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

        // Création du compte courant
        $sqlCourant = "INSERT INTO accounts (user_id, account_type, balance, created_at, updated_at) 
                       VALUES (:user_id, 'courant', 0.00, NOW(), NOW())";
        $stmtCourant = $pdo->prepare($sqlCourant);
        $stmtCourant->execute(['user_id' => $user_id]);

        // Création du compte épargne
        $sqlEpargne = "INSERT INTO accounts (user_id, account_type, balance, created_at, updated_at) 
                       VALUES (:user_id, 'epargne', 0.00, NOW(), NOW())";
        $stmtEpargne = $pdo->prepare($sqlEpargne);
        $stmtEpargne->execute(['user_id' => $user_id]);

        // Valider la transaction
        $pdo->commit();

        $_SESSION['success_message'] = "Votre compte a été activé avec succès!";
        header('Location: client/profil.php');
        exit();
    } catch(PDOException $e) {
        // En cas d'erreur, annuler toutes les opérations
        $pdo->rollBack();
        $_SESSION['error_message'] = "Erreur lors de l'activation: " . $e->getMessage();
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
    <title>Activation du compte - BanKa2KA</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl w-full space-y-8 bg-white p-8 rounded-lg shadow">
            <div>
                <h2 class="text-center text-3xl font-extrabold text-gray-900">
                    Bienvenue sur BanKa2KA
                </h2>
                <p class="mt-2 text-center text-sm text-gray-600">
                    Pour activer votre compte, veuillez compléter vos informations personnelles
                </p>
            </div>

            <?php if (isset($_SESSION['error_message'])): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <?php 
                    echo $_SESSION['error_message'];
                    unset($_SESSION['error_message']);
                    ?>
                </div>
            <?php endif; ?>

            <form class="mt-8 space-y-6" method="POST">
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
                        <input type="text" name="nom" required
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                            value="<?php echo htmlspecialchars($user['lastname'] ?? ''); ?>"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Prénom</label>
                        <input type="text" name="prenom" required
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                            value="<?php echo htmlspecialchars($user['firstname'] ?? ''); ?>"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                        <input type="date" name="date_naissance" required
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                            value="<?php echo htmlspecialchars($user['birthdate'] ?? ''); ?>"
                        />
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
                        <input type="email" name="email" required
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                            value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                        <input type="tel" name="telephone" required
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                            value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                        />
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Adresse</label>
                        <input type="text" name="adresse" required
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                            value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Code postal</label>
                        <input type="text" name="code_postal" required
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                            value="<?php echo htmlspecialchars($user['postal_code'] ?? ''); ?>"
                        />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Ville</label>
                        <input type="text" name="ville" required
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                            value="<?php echo htmlspecialchars($user['city'] ?? ''); ?>"
                        />
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" 
                        class="group relative w-full md:w-auto flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Activer mon compte
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html> 