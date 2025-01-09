<?php
require_once '../config/db.php';
require_once('../classes/Transactions.php');
require_once('../classes/CompteCourant.php');

session_start();

// Verifier si l'utilisateur est connecte
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth.php');
    exit();
}

// Récupérer l'ID de l'utilisateur
$userId = $_SESSION['user_id'];

// Initialiser la connexion à la base de données
$database = new Database();
$pdo = $database->connect();

// Créer une instance de la classe Compte pour récupérer les comptes
$compte = new CompteCourant($pdo);
$comptes = $compte->getComptesByUserId($userId);

// Créer une instance de la classe Transactions
$transactions = new Transactions($pdo);

// Calculer les totaux pour tous les comptes de l'utilisateur
$totalDeposits = 0;
$totalWithdrawals = 0;
foreach ($comptes as $compte) {
    $totalDeposits += $transactions->getTotalDeposits($compte['id']);
    $totalWithdrawals += $transactions->getTotalWithdrawals($compte['id']);
}
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Banque - Historique des transactions</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
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
                <a href="historique.php" class="flex items-center w-full p-4 space-x-3 bg-blue-50 text-blue-600 border-r-4 border-blue-600">
                    <i data-lucide="history"></i>
                    <span>Historique</span>
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

        <!-- Button to toggle sidebar on mobile -->
        <button class="md:hidden p-4 text-gray-600" id="toggleSidebar">
            <i data-lucide="menu"></i>
        </button>

        <!-- Main Content -->
        <div class="flex-1 p-4 md:p-8">
            <h2 class="text-2xl font-bold text-gray-800">Historique des transactions</h2>

            <!-- Filtres -->
            <div class="bg-white rounded-lg shadow mt-6 p-4 md:p-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-4">Filtres</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Compte</label>
                        <select class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">Tous les comptes</option>
                            <option value="current">Compte Courant</option>
                            <option value="savings">Compte Épargne</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Période</label>
                        <select class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500">
                            <option value="7">7 derniers jours</option>
                            <option value="30">30 derniers jours</option>
                            <option value="90">3 derniers mois</option>
                            <option value="365">12 derniers mois</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type d'opération</label>
                        <select class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">Toutes les opérations</option>
                            <option value="credit">Transfert</option>
                            <option value="debit">dépôt</option>
                            <option value="transfer">Retrait</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Montant</label>
                        <div class="flex space-x-2">
                            <input 
                                type="number" 
                                placeholder="0.00"
                                min='1'
                                class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500"
                            />
                        </div>
                    </div>
                </div>

                <!-- Date personnalisée (caché par défaut) -->
                <div class="hidden mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de début</label>
                        <input 
                            type="date" 
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date de fin</label>
                        <input 
                            type="date" 
                            class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500"
                        />
                    </div>
                </div>

                <div class="mt-4 flex flex-col md:flex-row justify-end space-x-0 md:space-x-4">
                    <!-- <button class="mb-2 md:mb-0 px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Réinitialiser
                    </button> -->
                    <!-- <button class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Appliquer les filtres
                    </button> -->
                </div>
            </div>

            <!-- Résumé -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total des entrées</h3>
                    <p class="text-2xl font-bold text-green-600 mt-2"><?php echo number_format($totalDeposits, 2); ?> MAD</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total des sorties</h3>
                    <p class="text-2xl font-bold text-red-600 mt-2"><?php echo number_format($totalWithdrawals, 2); ?> MAD</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Solde de la période</h3>
                    <p class="text-2xl font-bold text-blue-600 mt-2"><?php echo ($totalDeposits - $totalWithdrawals > 0 ? '+' : ''); ?> <?php echo number_format($totalDeposits - $totalWithdrawals, 2); ?> MAD</p>
                </div>
            </div>

            <!-- Liste des transactions -->
            <div class="bg-white rounded-lg shadow mt-6">
                <div class="p-4 md:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">Dernières transactions</h3>
                        <button class="text-blue-600 hover:text-blue-800 flex items-center">
                            <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                            Exporter
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full table-auto">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Compte</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Détails</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Montant</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                // Récupérer toutes les transactions de l'utilisateur
                                $allTransactions = $transactions->getAllTransactionsByUserId($userId);
                                
                                foreach ($allTransactions as $transaction): 
                                    $montant = number_format($transaction['amount'], 2);
                                    $date = date('d/m/Y H:i', strtotime($transaction['created_at']));
                                    $type = ucfirst($transaction['transaction_type']);
                                    $compte = ucfirst($transaction['account_type']);
                                    
                                    // Définir la classe CSS pour le montant selon le type de transaction
                                    $montantClass = 'text-gray-900';
                                    if ($transaction['transaction_type'] === 'depot' || ($transaction['transaction_type'] === 'transfert' && $transaction['beneficiary_account_id'] === null)) {
                                        $montantClass = 'text-green-600';
                                        $montant = '+ ' . $montant;
                                    } else {
                                        $montantClass = 'text-red-600';
                                        $montant = '- ' . $montant;
                                    }
                                ?>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo $date; ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $type; ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900"><?php echo $compte; ?></td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?php if ($transaction['transaction_type'] === 'transfert' && $transaction['beneficiary_account_id']): ?>
                                                <?php echo $transaction['beneficiary_account_id'] ? 'Transfert vers ' . $transaction['beneficiary_account_type'] : ''; ?>
                                            <?php else: ?>
                                                <?php echo $type; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm <?php echo $montantClass; ?>"><?php echo $montant; ?> MAD</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Toggle sidebar visibility on mobile
        const toggleButton = document.getElementById('toggleSidebar');
        const sidebar = document.querySelector('.w-64');

        toggleButton.addEventListener('click', () => {
            sidebar.classList.toggle('hidden');
        });

        lucide.createIcons();
    </script>
</body>
</html>