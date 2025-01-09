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


  // fonctions pour faire un virement entre les deux comptes

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
  } 
?>