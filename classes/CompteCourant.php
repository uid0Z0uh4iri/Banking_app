<?php

require_once __DIR__ . '/Compte.php';

class CompteCourant extends Compte {
    protected function verifierMontant($montant): bool {

        // Verifier si le montant est positif et superieur a zero
        return $montant > 0;
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
            
            // Pour un compte courant, on verifie simplement si le compte existe
            return $balance !== false;
        } catch (PDOException $e) {
            return false;
        }
    }
}
