<?php
require_once('../config/database.php');
require_once('includes/user_info.php');
require_once('includes/form_handler.php');
require_once('includes/image_handler.php');
session_start();

// Debug: Afficher toutes les données POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log('POST Data: ' . print_r($_POST, true));
    error_log('Session user_id: ' . $_SESSION['user_id']);
}

// Initialisation des messages
$message_success = $message_error = $password_success = $password_error = null;

// Gestion de la mise à jour du mot de passe
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_password'])) {
    $result = handlePasswordUpdate(
        $pdo,
        $_POST['current_password'] ?? '',
        $_POST['new_password'] ?? '',
        $_POST['confirm_password'] ?? '',
        $_SESSION['user_id']
    );
    
    if (isset($result['error'])) {
        $_SESSION['password_error'] = $result['error'];
    } else {
        $_SESSION['password_success'] = $result['success'];
    }
    header('Location: profil.php');
    exit();
}

// Gestion de l'upload de photo de profil
elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    $result = handleProfilePicUpload($pdo, $_FILES['profile_pic'], $_SESSION['user_id']);
    
    if (isset($result['error'])) {
        $_SESSION['upload_error'] = $result['error'];
    } else {
        $_SESSION['upload_success'] = $result['success'];
    }
    header('Location: profil.php');
    exit();
}

// Gestion de la mise à jour du profil
elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log('Tentative de mise à jour du profil');
    $result = handleProfileUpdate($pdo, $_POST, $_SESSION['user_id']);
    error_log('Résultat de la mise à jour: ' . print_r($result, true));
    
    if (isset($result['error'])) {
        $_SESSION['message_error'] = $result['error'];
    } else {
        $_SESSION['message_success'] = $result['success'];
    }
    header('Location: profil.php');
    exit();
}

// Récupération des messages de session
$message_success = $_SESSION['message_success'] ?? null;
$message_error = $_SESSION['message_error'] ?? null;
$password_success = $_SESSION['password_success'] ?? null;
$password_error = $_SESSION['password_error'] ?? null;
$upload_success = $_SESSION['upload_success'] ?? null;
$upload_error = $_SESSION['upload_error'] ?? null;

// Nettoyage des messages de session
unset(
    $_SESSION['message_success'],
    $_SESSION['message_error'],
    $_SESSION['password_success'],
    $_SESSION['password_error'],
    $_SESSION['upload_success'],
    $_SESSION['upload_error']
);

// Récupération des données de l'utilisateur
$user = getUserInfo($pdo, $_SESSION['user_id']);
if (isset($user['error'])) {
    $message_error = $user['error'];
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
                <a href="historique.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="history"></i>
                    <span>Historique</span>
                </a>
                <a href="profil.php" class="flex items-center w-full p-4 space-x-3 bg-blue-50 text-blue-600 border-r-4 border-blue-600">
                    <i data-lucide="user"></i>
                    <span>Profil</span>
                </a>
                <a href="../logout.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-red-50 hover:text-red-600">
                    <i data-lucide="log-out"></i>
                    <span>Deconnexion</span>
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
                            <form class="space-y-6" method="POST" enctype="multipart/form-data">
                                <!-- Photo de profil -->
                                <div class="flex items-center space-x-6">
                                    <div class="relative">
                                        <img 
                                            src="<?php echo isset($user['profile_pic']) ? '../images/' . $user['profile_pic'] : '../assets/images/default-avatar.png'; ?>" 
                                            alt="Photo de profil" 
                                            class="w-24 h-24 rounded-full object-cover"
                                        >
                                    </div>
                                    <div class="flex-1">
                                        <label class="block">
                                            <span class="sr-only">Choisir une photo</span>
                                            <input 
                                                type="file" 
                                                name="profile_pic" 
                                                accept="image/*"
                                                class="block w-full text-sm text-gray-500
                                                    file:mr-4 file:py-2 file:px-4
                                                    file:rounded-full file:border-0
                                                    file:text-sm file:font-semibold
                                                    file:bg-blue-50 file:text-blue-700
                                                    hover:file:bg-blue-100"
                                            >
                                        </label>
                                        <button 
                                            type="submit"
                                            class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm"
                                        >
                                            Mettre à jour la photo
                                        </button>
                                    </div>
                                </div>

                                <?php if (isset($_SESSION['upload_error'])): ?>
                                    <div class="text-red-500 text-sm mt-2">
                                        <?php 
                                        echo $_SESSION['upload_error'];
                                        unset($_SESSION['upload_error']);
                                        ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (isset($_SESSION['upload_success'])): ?>
                                    <div class="text-green-500 text-sm mt-2">
                                        <?php 
                                        echo $_SESSION['upload_success'];
                                        unset($_SESSION['upload_success']);
                                        ?>
                                    </div>
                                <?php endif; ?>

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
                                            <input type="checkbox" class="rounded text-blue-600" />
                                            <span class="ml-2 text-sm text-gray-700">Notifications par email</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="rounded text-blue-600" />
                                            <span class="ml-2 text-sm text-gray-700">Notifications SMS</span>
                                        </label>
                                        <label class="flex items-center">
                                            <input type="checkbox" class="rounded text-blue-600"/>
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
                                            <input type="checkbox" class="rounded text-blue-600"  />
                                            <span class="ml-2 text-sm text-gray-700">Double authentification</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="pt-4">
                                    <h4 class="text-sm font-medium text-gray-700">Langue et région</h4>
                                    <div class="mt-2 space-y-4">
                                        <select class="block w-full rounded-md border border-gray-300 px-3 py-2">
                                            <option>Français</option>
                                            <option>Arabe</option>
                                            <option>English</option>
                                        </select>
                                        <select class="block w-full rounded-md border border-gray-300 px-3 py-2">
                                            <option>Maroc (MAD)</option>
                                            <option>Europe (EUR)</option>
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
                                    Désactiver mon compte
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