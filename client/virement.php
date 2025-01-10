<?php 
session_start();

require_once '../config/db.php';
require_once '../classes/User.php';
require_once '../classes/Transactions.php';

// Verifier si l'utilisateur est connecte
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth.php');
    exit();
}

// Initialiser la connexion et l'objet User
$db = new Database();
$pdo = $db->connect();
$user = new User($pdo);
$transaction = new Transactions($pdo);

// Traitement du formulaire de virement
$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST['amount']);
    try {
        $fromAccount = $_POST['debitAccount'];
        $toAccount = $_POST['creditAccount'];
        $amount = floatval($_POST['amount']);

        if ($fromAccount === $toAccount) {
            throw new Exception("Vous ne pouvez pas faire un virement vers le même compte");
        }

        if ($amount <= 0) {
            throw new Exception("Le montant doit être supérieur à 0");
        }

        // Récupérer les IDs des comptes
        $accounts = $user->getAccounts();
        if (!isset($accounts[$fromAccount]) || !isset($accounts[$toAccount])) {
            throw new Exception("Un des comptes n'existe pas");
        }
        
        $fromAccountId = $accounts[$fromAccount]['id'];
        $toAccountId = $accounts[$toAccount]['id'];

        // Effectuer le transfert
        $transaction->transferBetweenAccounts($fromAccountId, $toAccountId, $amount);
        
        // Rediriger avec un message de succès
        header('Location: virement.php?message=' . urlencode("Le virement a été effectué avec succès") . '&type=success');
        exit();
        
    } catch (Exception $e) {
        $message = $e->getMessage();
        $messageType = "error";
    }
} else {
    // Recuperer les messages de la redirection si présents
    if (isset($_GET['message']) && isset($_GET['type'])) {
        $message = $_GET['message'];
        $messageType = $_GET['type'];
    }
    
    // Recuperer les soldes des comptes
    $balances = $user->getAccountBalances();
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Banque - Virements</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar (même contenu que précédemment) -->
        <div class="w-64 bg-white shadow-lg">
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
                <a href="virement.php" class="flex items-center w-full p-4 space-x-3 bg-blue-50 text-blue-600 border-r-4 border-blue-600">
                    <i data-lucide="send"></i>
                    <span>Virements</span>
                </a>
                <a href="historique.php" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
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

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <h2 class="text-2xl font-bold text-gray-800">Effectuer un transfert</h2>
            
            <div class="bg-white p-6 rounded-lg shadow mt-6">
                <?php if ($message): ?>
                    <div class="mb-4 p-4 rounded <?php echo $messageType === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'; ?>">
                        <?php echo htmlspecialchars($message); ?>
                    </div>
                <?php endif; ?>
                <form class="space-y-4" method="POST" action="">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Compte à débiter</label>
                        <select name="debitAccount" id="debitAccount" class="mt-1 block w-full rounded-md border border-gray-300 p-2">
                            <option value="courant">Compte Courant - <?php echo number_format($balances['courant'], 2, ',', ' '); ?> MAD</option>
                            <option value="epargne">Compte Épargne - <?php echo number_format($balances['epargne'], 2, ',', ' '); ?> MAD</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Compte à bénéficier</label>
                        <select name="creditAccount" id="creditAccount" class="mt-1 block w-full rounded-md border border-gray-300 p-2">
                            <option value="courant">Compte Courant - <?php echo number_format($balances['courant'], 2, ',', ' '); ?> MAD</option>
                            <option value="epargne">Compte Épargne - <?php echo number_format($balances['epargne'], 2, ',', ' '); ?> MAD</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Montant</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">MAD</span>
                            </div>
                            <input 
                                name="amount"
                                type="number" 
                                min="0.01" 
                                step="0.01"
                                class="pl-[60px] block w-full rounded-md border border-gray-300 p-2" 
                                placeholder="0.00"
                                required
                            />
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700">
                        Effectuer le virement
                    </button>
                </form>
            </div>

            <!-- Derniers virements -->
            <div class="bg-white rounded-lg shadow mt-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-700">Derniers virements</h3>
                    <div class="mt-4 space-y-4">
                        <?php
                        $transactions = $user->getRecentTransactions(5);
                        foreach ($transactions as $transaction) {
                            $amount = number_format($transaction['amount'], 2, ',', ' ');
                            $date = date('d F Y', strtotime($transaction['created_at']));
                            $isDebit = in_array($transaction['transaction_type'], ['retrait', 'virement_sortant']);
                            $amountClass = $isDebit ? 'text-red-600' : 'text-green-600';
                            $amountPrefix = $isDebit ? '-' : '+';
                            ?>
                            <div class="flex items-center justify-between p-4 border-b">
                                <div>
                                    <p class="font-medium"><?php echo ucfirst($transaction['transaction_type']); ?></p>
                                    <p class="text-sm text-gray-500"><?php echo $date; ?></p>
                                </div>
                                <p class="<?php echo $amountClass; ?> font-medium"><?php echo $amountPrefix; ?>MAD <?php echo $amount; ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/virement.js"></script>
</body>
</html>