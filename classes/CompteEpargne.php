<?php

require_once __DIR__ . '/Compte.php';

class CompteEpargne extends Compte {
    public const MONTANT_MINIMUM = 0.01; // montant minimum pour un depot
    public const SOLDE_MINIMUM = 1000;  // solde minimum a maintenir

    protected function verifierMontant($montant): bool {
        // Verifier si le montant est positif et superieur au montant minimum requis
        return $montant > 0 && $montant >= self::MONTANT_MINIMUM;
    }

    protected function verifierSolde($user_id, $account_type): bool {
        try {
            $stmt = $this->pdo->prepare("
                SELECT balance 
                FROM accounts 
                WHERE user_id = ? AND account_type = ?
            ");
            $stmt->execute([$user_id, $account_type]);
            $balance = $stmt->fetchColumn();
            
            // Pour un compte épargne, on verifie si le solde est superieur au minimum requis
            return $balance !== false && $balance >= self::SOLDE_MINIMUM;
        } catch (PDOException $e) {
            return false;
        }
    }
}
