document.addEventListener('DOMContentLoaded', function() {
    const debitAccount = document.getElementById('debitAccount');
    const creditAccount = document.getElementById('creditAccount');

            // Fonction pour mettre a jour les options disponibles
    function updateAccounts(sourceSelect, targetSelect) {
    const selectedValue = sourceSelect.value;
                
    // Reactiver toutes les options dans le select cible
    Array.from(targetSelect.options).forEach(option => {
            option.disabled = false;
    });
                
                // Desactiver l'option selectionnee dans l'autre select
                const optionToDisable = targetSelect.querySelector(`option[value="${selectedValue}"]`);
                if (optionToDisable) {
                    optionToDisable.disabled = true;
                }

                // Si l'option desactivee etait selectionnee, selectionner l'autre option
                if (targetSelect.value === selectedValue) {
                    const availableOption = Array.from(targetSelect.options)
                        .find(option => !option.disabled);
                    if (availableOption) {
                        targetSelect.value = availableOption.value;
                    }
                }
            }

            // Ajouter les ecouteurs d'evenements
            debitAccount.addEventListener('change', () => updateAccounts(debitAccount, creditAccount));
            creditAccount.addEventListener('change', () => updateAccounts(creditAccount, debitAccount));

            // Initialiser l'etat au chargement
            updateAccounts(debitAccount, creditAccount);
        });
