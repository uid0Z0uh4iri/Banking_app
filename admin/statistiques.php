<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - Dashboard</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>


<?php


include '../classes/User.php';
include '../config/database.php';

// Vérifier si l'utilisateur est connecté et est admin
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
//     header('Location: ../auth.php');
//     exit;
// }


// Créer une instance de User avec la connexion PDO
$user = new User($pdo);

// recuperer les statistiques


$TotaleDepot = $user->getTotaleDepot();
$TotaleRetrait= $user->getTotaleRetrait();





?>




<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-gray-900">
            <div class="flex flex-col h-full">
                <div class="p-6">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold text-white">Admin Panel</h1>
                    </div>
                    <p class="text-gray-400 text-sm">Gestion bancaire</p>
                </div>

                <!-- Navigation -->
                <nav class="mt-6 flex-grow">
                    <a href="#" class="flex items-center w-full px-6 py-3 text-white bg-gray-800">
                        <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="clients.php" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                        <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                        <span>Clients</span>
                    </a>
                    <a href="compte.html" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                        <i data-lucide="credit-card" class="w-5 h-5 mr-3"></i>
                        <span>Comptes</span>
                    </a>
                    <a href="transactions.html" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                        <i data-lucide="repeat" class="w-5 h-5 mr-3"></i>
                        <span>Transactions</span>
                    </a>
                    <a href="#" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                        <i data-lucide="bell" class="w-5 h-5 mr-3"></i>
                        <span>Notifications</span>
                    </a>
                    <a href="#" class="flex items-center w-full px-6 py-3 text-gray-400 hover:text-white hover:bg-gray-800">
                        <i data-lucide="settings" class="w-5 h-5 mr-3"></i>
                        <span>Paramètres</span>
                    </a>
                </nav>

                <!-- Profil Admin -->
                <div class="border-t border-gray-800 p-6">
                    <div class="flex items-center w-full text-white rounded-lg p-2">
                        <img src="/api/placeholder/32/32" alt="Admin" class="w-8 h-8 rounded-full">
                        <div class="ml-3 flex-grow">
                            <p class="text-sm font-medium">Admin</p>
                            <p class="text-xs text-gray-400">admin@banque.fr</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h2 class="text-2xl font-bold mb-6">Tableau de bord</h2>
            
            <!-- Statistics Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Total Deposits Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total des dépôts</p>
                            <!-- Implode converts array to string -->
                            <h3 class="text-2xl font-bold mt-2"><?php  echo implode($TotaleDepot);  ?></h3>
                        </div>
                        <div class="bg-green-100 p-3 rounded-full">
                            <i data-lucide="arrow-down-circle" class="w-6 h-6 text-green-600"></i>
                        </div>
                    </div>
                    
                </div>

                <!-- Total Withdrawals Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Total des retraits</p>
                            <h3 class="text-2xl font-bold mt-2"><?php  echo implode($TotaleRetrait);  ?></h3>
                        </div>
                        <div class="bg-red-100 p-3 rounded-full">
                            <i data-lucide="arrow-up-circle" class="w-6 h-6 text-red-600"></i>
                        </div>
                    </div>
                </div>

                <!-- Total Balance Card -->
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 text-sm">Solde total</p>
                            <h3 class="text-2xl font-bold mt-2">€0.00</h3>
                        </div>
                        <div class="bg-blue-100 p-3 rounded-full">
                            <i data-lucide="wallet" class="w-6 h-6 text-blue-600"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
    </script>
</body>
</html>