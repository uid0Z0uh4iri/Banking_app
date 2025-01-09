<?php 
  class Transactions {	
    private $id;
    private $account_id;
    private $transaction_type;
    private $amount;
    private $beneficiary_account_id;
    private $created_at;
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

  // fonctions pour faire un virement entre les deux comptes avec polimorphisme

    public function transferBetweenAccounts($fromAccountId, $toAccountId, $amount) {
        try {
            $this->pdo->beginTransaction();

            // Get account types for both accounts
            $stmt = $this->pdo->prepare("SELECT id, account_type, balance FROM accounts WHERE id IN (?, ?)");
            $stmt->execute([$fromAccountId, $toAccountId]);
            $accounts = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $fromAccount = null;
            $toAccount = null;
            foreach ($accounts as $account) {
                if ($account['id'] == $fromAccountId) {
                    $fromAccount = $account;
                } else {
                    $toAccount = $account;
                }
            }

            // Calculate fees if transfer is from epargne to courant account
            $fee = 0;
            if ($fromAccount['account_type'] === 'epargne' && $toAccount['account_type'] === 'courant') {
                $fee = $amount * 0.025; // 2.5% fee
            }

            $totalDebit = $amount + $fee;

            if ($fromAccount['balance'] < $totalDebit) {
                throw new Exception("Solde insuffisant pour effectuer le transfert");
            }

            // Debiter le compte source (montant + frais)
            $stmt = $this->pdo->prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?");
            $stmt->execute([$totalDebit, $fromAccountId]);

            // Crediter le compte destinataire (montant sans frais)
            $stmt = $this->pdo->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?");
            $stmt->execute([$amount, $toAccountId]);

            // Enregistrer la transaction pour le debit
            $stmt = $this->pdo->prepare("INSERT INTO transactions (account_id, transaction_type, amount, beneficiary_account_id, created_at) VALUES (?, 'transfert', ?, ?, NOW())");
            $stmt->execute([$fromAccountId, $totalDebit, $toAccountId]);

            // Enregistrer la transaction pour le credit
            $stmt = $this->pdo->prepare("INSERT INTO transactions (account_id, transaction_type, amount, beneficiary_account_id, created_at) VALUES (?, 'transfert', ?, ?, NOW())");
            $stmt->execute([$toAccountId, $amount, $fromAccountId]);

            $this->pdo->commit();
            return [
                'success' => true,
                'fee' => $fee
            ];

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
    // fonctions pour enregistrer les retraits et les depots dans la table transactions
    public function recordTransaction($accountId, $type, $amount) {
        try {
            // Vérifier que le type est valide
            if (!in_array($type, ['depot', 'retrait'])) {
                throw new Exception("Type de transaction invalide");
            }

            // Enregistrer la transaction
            $stmt = $this->pdo->prepare("INSERT INTO transactions (account_id, transaction_type, amount, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$accountId, $type, $amount]);

            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
 // fonction pour calculer le total des depots
    public function getTotalDeposits($accountId) {
        try {
            $stmt = $this->pdo->prepare("SELECT SUM(amount) as total FROM transactions WHERE account_id = ? AND transaction_type = 'depot'");
            $stmt->execute([$accountId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            throw $e;
        }
    }
 // fonction pour calculer le total des retrait
    public function getTotalWithdrawals($accountId) {
        try {
            $stmt = $this->pdo->prepare("SELECT SUM(amount) as total FROM transactions WHERE account_id = ? AND transaction_type = 'retrait'");
            $stmt->execute([$accountId]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (Exception $e) {
            throw $e;
        }
    }

  // fonction pour afficher tout les transactions du client dans l'historique

    public function getAllTransactionsByUserId($userId) {
        try {
            $stmt = $this->pdo->prepare("
                SELECT t.*, a.account_type, ba.account_type as beneficiary_account_type 
                FROM transactions t
                INNER JOIN accounts a ON t.account_id = a.id
                LEFT JOIN accounts ba ON t.beneficiary_account_id = ba.id
                WHERE a.user_id = ?
                ORDER BY t.created_at DESC
            ");
            $stmt->execute([$userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw $e;
        }
    }
  } 
?>