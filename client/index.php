<?php 
session_start();

require_once '../config/db.php';
require_once '../classes/User.php';

// Verifier si l'utilisateur est connecte
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth.php');
    exit();
}

// Initialiser la connexion et l'objet User
$db = new Database();
$pdo = $db->connect();
$user = new User($pdo);

// Recuperer les soldes des comptes
$balances = $user->getAccountBalances();

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Banque - Tableau de bord</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white shadow-lg md:block hidden">
            <div class="p-6">
                <h1 class="text-2xl font-bold text-blue-600">BanKa2KA</h1>
            </div>
            <nav class="mt-6">
            <a href="index.php" class="flex items-center w-full p-4 space-x-3 bg-blue-50 text-blue-600 border-r-4 border-blue-600">
                    <i data-lucide="history"></i>
                    <span>Tableau de bord </span>
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
                    <i data-lucide="credit-card"></i>
                    <span>Historiques</span>
                </a>
                <a href="profil.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="user"></i>
                    <span>Profil</span>
                </a>
                <a href="../logout.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-red-50 hover:text-red-600">
                    <i data-lucide="log-out"></i>
                    <span>Deconnexion</span>
                </a>
            </nav>
        </div>

        <!-- Toggle Button for Mobile -->
        <button class="md:hidden p-4 text-gray-600 hover:text-blue-600" id="toggleSidebar">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <!-- Add this button for desktop view -->
        <button class="hidden md:block p-4 text-gray-600 hover:text-blue-600" id="toggleSidebarDesktop">
            <i data-lucide="menu" class="w-6 h-6"></i>
        </button>

        <!-- Main Content -->
        <div class="flex-1 p-4 md:p-8">
            <h2 class="text-2xl font-bold text-gray-800">Tableau de bord</h2>
            
            <!-- Account Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Compte Courant</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">MAD <?php echo number_format($balances['courant'], 2, ',', ' '); ?></p>
                </div>
                
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-700">Compte Épargne</h3>
                    <p class="text-3xl font-bold text-gray-900 mt-2">MAD <?php echo number_format($balances['epargne'], 2, ',', ' '); ?></p>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
                <a href="virement.php" class="flex items-center justify-center p-4 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    <i data-lucide="send" class="w-5 h-5 mr-2"></i>
                    <span class="text-center">Nouveau virement</span>
                </a>
                <a href="alimenter.php" class="flex items-center justify-center p-4 bg-green-600 text-white rounded-lg hover:bg-green-700">
                    <i data-lucide="plus-circle" class="w-5 h-5 mr-2"></i>
                    <span class="text-center">Alimenter compte</span>
                </a>
                <a href="retrait.php" class="flex items-center justify-center p-4 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                    <i data-lucide="users" class="w-5 h-5 mr-2"></i>
                    <span class="text-center">Extraire de l'argent</span>
                </a>
            </div>

            <!-- Recent Transactions -->
            <div class="bg-white rounded-lg shadow mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Transactions récentes</h3>
                    <div class="mt-4 space-y-4">
                        <div class="flex items-center justify-between p-4 border-b">
                            <div>
                                <p class="font-medium">Virement à John Doe</p>
                                <p class="text-sm text-gray-500">12 janvier 2025</p>
                            </div>
                            <p class="text-red-600 font-medium">-€125.00</p>
                        </div>
                        <div class="flex items-center justify-between p-4 border-b">
                            <div>
                                <p class="font-medium">Virement reçu de Marie Martin</p>
                                <p class="text-sm text-gray-500">11 janvier 2025</p>
                            </div>
                            <p class="text-green-600 font-medium">+€350.00</p>
                        </div>
                        <div class="flex items-center justify-between p-4 border-b">
                            <div>
                                <p class="font-medium">Paiement Carte Bancaire</p>
                                <p class="text-sm text-gray-500">10 janvier 2025</p>
                            </div>
                            <p class="text-red-600 font-medium">-€42.50</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Toggle Button for Mobile -->
<button class="md:hidden p-4 text-gray-600 hover:text-blue-600" id="toggleSidebar">
    <i data-lucide="menu" class="w-6 h-6"></i>
</button>

<!-- Add this button for desktop view -->
<button class="hidden md:block p-4 text-gray-600 hover:text-blue-600" id="toggleSidebarDesktop">
    <i data-lucide="menu" class="w-6 h-6"></i>
</button>


<script src ="../assets/js/main.js"></script>
</body>
</html>