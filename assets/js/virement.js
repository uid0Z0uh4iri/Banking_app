 // Attendre que le DOM soit chargé
        document.addEventListener('DOMContentLoaded', function() {
            const debitAccount = document.getElementById('debitAccount');
            const creditAccount = document.getElementById('creditAccount');

            // Fonction pour mettre à jour les options disponibles
            function updateAccounts(sourceSelect, targetSelect) {
                const selectedValue = sourceSelect.value;
                
                // Réactiver toutes les options dans le select cible
                Array.from(targetSelect.options).forEach(option => {
                    option.disabled = false;
                });
                
                // Désactiver l'option sélectionnée dans l'autre select
                const optionToDisable = targetSelect.querySelector(`option[value="${selectedValue}"]`);
                if (optionToDisable) {
                    optionToDisable.disabled = true;
                }

                // Si l'option désactivée était sélectionnée, sélectionner l'autre option
                if (targetSelect.value === selectedValue) {
                    const availableOption = Array.from(targetSelect.options)
                        .find(option => !option.disabled);
                    if (availableOption) {
                        targetSelect.value = availableOption.value;
                    }
                }
            }

            // Ajouter les écouteurs d'événements
            debitAccount.addEventListener('change', () => updateAccounts(debitAccount, creditAccount));
            creditAccount.addEventListener('change', () => updateAccounts(creditAccount, debitAccount));

            // Initialiser l'état au chargement
            updateAccounts(debitAccount, creditAccount);
        });
