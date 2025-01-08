<?php
// Au début du fichier, avant le HTML
require_once('../config/database.php');
session_start();

// Logic dial update password (mettre ce bloc en PREMIER)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $user_id = 1; // Normalement ghadi takhdu men session

    try {
        // Vérifier si le mot de passe actuel est correct
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();

        if (!password_verify($current_password, $user['password'])) {
            $_SESSION['password_error'] = "Le mot de passe actuel est incorrect";
        } 
        elseif ($new_password !== $confirm_password) {
            $_SESSION['password_error'] = "Les nouveaux mots de passe ne correspondent pas";
        }
        elseif (strlen($new_password) < 8) {
            $_SESSION['password_error'] = "Le nouveau mot de passe doit contenir au moins 8 caractères";
        }
        else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            
            // Mise à jour uniquement du mot de passe
            $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
            $stmt->execute([
                'password' => $hashed_password,
                'user_id' => $user_id
            ]);

            $_SESSION['password_success'] = "Votre mot de passe a été mis à jour avec succès";
        }

        header('Location: profil.php');
        exit();

    } catch(PDOException $e) {
        $_SESSION['password_error'] = "Erreur lors de la mise à jour du mot de passe: " . $e->getMessage();
        header('Location: profil.php');
        exit();
    }
}

// Logic dial update profile (mettre ce bloc APRÈS)
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
    
    $user_id = 1; // Normalement ghadi takhdu men session

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

        $_SESSION['message_success'] = "Les informations ont été mises à jour avec succès!";
        header('Location: profil.php');
        exit();
    } catch(PDOException $e) {
        $_SESSION['message_error'] = "Erreur lors de la mise à jour: " . $e->getMessage();
        header('Location: profil.php');
        exit();
    }
}

// Récupération des messages de la session
$message_success = $_SESSION['message_success'] ?? null;
$message_error = $_SESSION['message_error'] ?? null;

// Ajouter avec les autres récupérations de messages
$password_success = $_SESSION['password_success'] ?? null;
$password_error = $_SESSION['password_error'] ?? null;

// Suppression des messages de la session après les avoir récupérés
unset($_SESSION['message_success']);
unset($_SESSION['message_error']);

// Ajouter avec les autres unset
unset($_SESSION['password_success']);
unset($_SESSION['password_error']);

// Récupération des données actuelles de l'utilisateur
try {
    $user_id = $_POST['user_id']; // Normalement ghadi takhdu men session
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
} catch(PDOException $e) {
    $message_error = "Erreur lors de la récupération des données: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Banque - Profil</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg md:w-1/4 lg:w-64 hidden md:block">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-blue-600">BanKa2KA</h1>
            </div>
            <nav class="mt-6">
                <a href="index.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="wallet"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="compte.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="credit-card"></i>
                    <span>Mes comptes</span>
                </a>
                <a href="virement.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="send"></i>
                    <span>Virements</span>
                </a>
                <!-- <a href="benificier.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="users"></i>
                    <span>Bénéficiaires</span>
                </a> -->
                <a href="historique.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="history"></i>
                    <span>Historique</span>
                </a>
                <a href="profil.php" class="flex items-center w-full p-4 space-x-3 bg-blue-50 text-blue-600 border-r-4 border-blue-600">
                    <i data-lucide="user"></i>
                    <span>Profil</span>
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h2 class="text-2xl font-bold text-gray-800">Mon Profil</h2>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                <!-- Informations Personnelles -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informations Personnelles</h3>
                            <form class="space-y-6" method="POST">
                                <!-- Photo de profil -->
                                <div class="flex items-center space-x-6">
                                    <div class="relative">
                                        <img 
                                            src="/api/placeholder/128/128" 
                                            alt="Photo de profil"
                                            class="w-32 h-32 rounded-full object-cover"
                                        />
                                        <button 
                                            type="button"
                                            class="absolute bottom-0 right-0 bg-blue-600 text-white p-2 rounded-full hover:bg-blue-700"
                                        >
                                            <i data-lucide="camera" class="w-4 h-4"></i>
                                        </button>
                                    </div>
                                    <div>
                                        <button 
                                            type="button"
                                            class="text-sm text-blue-600 hover:text-blue-800"
                                        >
                                            Changer la photo
                                        </button>
                                        <p class="text-xs text-gray-500 mt-1">
                                            JPG, PNG ou GIF. Max 1MB.
                                        </p>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Civilité</label>
                                        <select name="civility" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                            <option value="M." <?php echo (isset($user['civility']) && $user['civility'] == 'M.') ? 'selected' : ''; ?>>M.</option>
                                            <option value="Mme" <?php echo (isset($user['civility']) && $user['civility'] == 'Mme') ? 'selected' : ''; ?>>Mme</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Numéro client</label>
                                        <input 
                                            type="text" 
                                            readonly 
                                            value="123456789" 
                                            class="mt-1 block w-full rounded-md border border-gray-300 bg-gray-50 px-3 py-2"
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nom</label>
                                        <input 
                                            type="text" 
                                            name="nom"
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value="<?php echo htmlspecialchars($user['lastname'] ?? ''); ?>"
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Prénom</label>
                                        <input 
                                            type="text" 
                                            name="prenom"
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value="<?php echo htmlspecialchars($user['firstname'] ?? ''); ?>"
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date de naissance</label>
                                        <input 
                                            type="date" 
                                            name="date_naissance"
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value="<?php echo htmlspecialchars($user['birthdate'] ?? ''); ?>"
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nationalité</label>
                                        <select name="nationalite" class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2">
                                            <option value="Française" <?php echo (isset($user['nationality']) && $user['nationality'] == 'Française') ? 'selected' : ''; ?>>Française</option>
                                            <option value="Autre" <?php echo (isset($user['nationality']) && $user['nationality'] == 'Autre') ? 'selected' : ''; ?>>Autre</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input 
                                            type="email" 
                                            name="email"
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value="<?php echo htmlspecialchars($user['email'] ?? '');?>"
                                        />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Téléphone</label>
                                        <input 
                                            type="tel" 
                                            name="telephone"
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>"
                                        />
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Adresse</label>
                                    <input 
                                        type="text" 
                                        name="adresse"
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        value="<?php echo htmlspecialchars($user['address'] ?? ''); ?>"
                                    />
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                                    <div class="col-span-2 md:col-span-1">
                                        <label class="block text-sm font-medium text-gray-700">Code postal</label>
                                        <input 
                                            type="text" 
                                            name="code_postal"
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value="<?php echo htmlspecialchars($user['postal_code'] ?? ''); ?>"
                                        />
                                    </div>

                                    <div class="col-span-2 md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Ville</label>
                                        <input 
                                            type="text" 
                                            name="ville"
                                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                            value="<?php echo htmlspecialchars($user['city'] ?? '');?>"
                                        />
                                    </div>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Sauvegarder les modifications
                                    </button>
                                </div>

                                <?php if (isset($message_success)): ?>
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                        <?php echo $message_success; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($message_error)): ?>
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                        <?php echo $message_error; ?>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <!-- Sécurité -->
                    <div class="bg-white rounded-lg shadow mt-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Sécurité</h3>
                            <form class="space-y-6" method="POST">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                                    <input 
                                        type="password" 
                                        name="current_password"
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        required
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                                    <input 
                                        type="password" 
                                        name="new_password"
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        required
                                    />
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                                    <input 
                                        type="password" 
                                        name="confirm_password"
                                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2"
                                        required
                                    />
                                </div>

                                <div class="flex justify-end pt-4">
                                    <button 
                                        type="submit" 
                                        name="update_password" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                    >
                                        Modifier le mot de passe
                                    </button>
                                </div>

                                <?php if (isset($password_success)): ?>
                                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                        <?php echo $password_success; ?>
                                    </div>
                                <?php endif; ?>

                                <?php if (isset($password_error)): ?>
                                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                        <?php echo $password_error; ?>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Paramètres et Préférences -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Préférences</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-700">Notifications</h4>
                                    <div class="mt-2 space-y-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" class="rounded text-blue-600" checked />
                                            <span class="ml-2 text-sm text-gray-700">Notifications par email</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="rounded text-blue-600" checked />
                                            <span class="ml-2 text-sm text-gray-700">Notifications SMS</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="rounded text-blue-600" checked />
                                            <span class="ml-2 text-sm text-gray-700">Alertes de sécurité</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <h4 class="text-sm font-medium text-gray-700">Confidentialité</h4>
                                    <div class="mt-2 space-y-2">
                                        <label class="flex items-center">
                                            <input type="checkbox" class="rounded text-blue-600" />
                                            <span class="ml-2 text-sm text-gray-700">Masquer le solde sur la page d'accueil</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="rounded text-blue-600" checked />
                                            <span class="ml-2 text-sm text-gray-700">Double authentification</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <h4 class="text-sm font-medium text-gray-700">Langue et région</h4>
                                    <div class="mt-2 space-y-4">
                                        <select class="block w-full rounded-md border border-gray-300 px-3 py-2">
                                            <option>Français</option>
                                            <option>English</option>
                                        </select>
                                        <select class="block w-full rounded-md border border-gray-300 px-3 py-2">
                                            <option>EUR (€)</option>
                                            <option>USD ($)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-6 pt-6 border-t">
                                <button 
                                    type="button"
                                    class="flex items-center text-red-600 hover:text-red-800"
                                >
                                    <i data-lucide="trash-2" class="w-4 h-4 mr-2"></i>
                                    Supprimer mon compte
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>