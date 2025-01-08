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

            // Verifier le solde du compte source
            $stmt = $this->pdo->prepare("SELECT balance FROM accounts WHERE id = ?");
            $stmt->execute([$fromAccountId]);
            $sourceBalance = $stmt->fetchColumn();

            if ($sourceBalance < $amount) {
                throw new Exception("Solde insuffisant pour effectuer le transfert");
            }

            // Debiter le compte source
            $stmt = $this->pdo->prepare("UPDATE accounts SET balance = balance - ? WHERE id = ?");
            $stmt->execute([$amount, $fromAccountId]);

            // Crediter le compte destinataire
            $stmt = $this->pdo->prepare("UPDATE accounts SET balance = balance + ? WHERE id = ?");
            $stmt->execute([$amount, $toAccountId]);

            // Enregistrer la transaction pour le debit
            $stmt = $this->pdo->prepare("INSERT INTO transactions (account_id, transaction_type, amount, beneficiary_account_id, created_at) VALUES (?, 'transfert', ?, ?, NOW())");
            $stmt->execute([$fromAccountId, $amount, $toAccountId]);

            // Enregistrer la transaction pour le credit
            $stmt = $this->pdo->prepare("INSERT INTO transactions (account_id, transaction_type, amount, beneficiary_account_id, created_at) VALUES (?, 'transfert', ?, ?, NOW())");
            $stmt->execute([$toAccountId, $amount, $fromAccountId]);

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            throw $e;
        }
    }
  } 
?>