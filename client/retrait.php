<?php 
session_start();
require_once '../config/db.php';
require_once '../classes/User.php';
require_once '../classes/Compte.php';
require_once '../classes/CompteCourant.php';
require_once '../classes/CompteEpargne.php';

// Verifier si l'utilisateur est connecte
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth.php');
    exit();
}

// Recuperer les soldes des comptes
$balances = $user->getAccountBalances();

// Initialiser la connexion et l'objet User
$db = new Database();
$pdo = $db->connect();
$user = new User($pdo);

// Traiter le formulaire de retrait
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
    $compte_type = htmlspecialchars($_POST['compte'] ?? 'courant', ENT_QUOTES, 'UTF-8');
    
    // Initialiser le bon type de compte en fonction de la selection
    $compte = $compte_type === 'epargne' ? new CompteEpargne($pdo) : new CompteCourant($pdo);

    if ($montant && $compte_type) {
        if ($compte->retraitCompte($_SESSION['user_id'], $montant, $compte_type)) {
            $_SESSION['success'] = "Retrait effectué avec succès";
        } else {
            if ($compte_type === 'epargne') {
                $_SESSION['error'] = "Erreur: Le solde minimum pour un compte épargne doit être maintenu à " . number_format(CompteEpargne::SOLDE_MINIMUM, 0, ',', ' ') . " FCFA";
            } else {
                $_SESSION['error'] = "Une erreur est survenue lors du retrait";
            }
        }
    } else {
        $_SESSION['error'] = "Veuillez remplir tous les champs correctement";
    }
    header('Location: retrait.php');
    exit();
}



?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Banque - Retarait Banquaire</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php if (isset($_SESSION['success'])): ?>
        <div class="fixed top-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50" role="alert">
            <strong class="font-bold">Succès!</strong>
            <p class="block sm:inline"><?php echo $_SESSION['success']; ?></p>
            <?php unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
 

    <?php if (isset($_SESSION['error'])): ?>
        <div class="fixed top-4 right-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded z-50" role="alert">
            <strong class="font-bold">Erreur!</strong>
            <p class="block sm:inline"><?php echo $_SESSION['error']; ?></p>
            <?php unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>
 

    <!-- Modal Alimenter Compte -->
    <div id="retraiterCompteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-20">
        <div class="relative top-20 mx-auto p-5 w-full max-w-md">
            <div class="bg-white rounded-lg shadow-xl">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">RETRAIT BANQUAIRE</h3>
                    <button onclick="toggleModal()" class="text-gray-400 hover:text-gray-500">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6">
                    <form id="retraiterForm" class="space-y-6" method="POST">
                        <!-- Sélection du compte -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Compte pour retirer de l'argent *</label>
                            <select name="compte" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Sélectionnez un compte</option>
                                <option value="courant">Compte Courant -  <span> <?php echo number_format($balances['courant'], 2, ',', ' '); ?> FCFA</span></option>
                                <option value="epargne">Compte Épargne - <span> <?php echo number_format($balances['epargne'], 2, ',', ' '); ?> FCFA</span></option>
                            </select>
                        </div>

                        <!-- Montant -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Montant *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3  flex items-center pointer-events-none">
                                    <span class="text-gray-500">FCFA</span>
                                </div>
                                <input 
                                    type="number" 
                                    name="montant"
                                    required
                                    min="0.01"
                                    step="0.01"
                                    class="w-full pl-[60px] pr-20 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="0.00"
                                >
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Montant minimum : 0.01 FCFA</p>
                        </div>

                        <!-- Message de confirmation -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i data-lucide="info" class="h-5 w-5 text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Le montant sera retiré sur votre compte selon le type de compte choisi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="flex justify-end space-x-3 p-6 border-t bg-gray-50">
                    <button 
                        type="button"
                        onclick="toggleModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        Annuler
                    </button>
                    <button 
                        type="submit"
                        form="retraiterForm"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Retraiter
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Fonction pour afficher/masquer le modal
        function toggleModal() {
            const modal = document.getElementById('retraiterCompteModal');
            if (!modal.classList.contains('hidden')) {
                window.location.href = 'index.php';
            }
        }

        // Fermer le modal si on clique en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('retraiterCompteModal');
            if (event.target === modal) {
                toggleModal();
            }
        }
    </script>
</body>
</html>