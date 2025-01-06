<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ma Banque - Alimenter Compte</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lucide/0.263.1/umd/lucide.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- Modal Alimenter Compte -->
    <div id="alimenterCompteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 w-full max-w-md">
            <div class="bg-white rounded-lg shadow-xl">
                <!-- Modal header -->
                <div class="flex justify-between items-center p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Alimenter mon compte</h3>
                    <button onclick="toggleModal()" class="text-gray-400 hover:text-gray-500">
                        <i data-lucide="x" class="w-6 h-6"></i>
                    </button>
                </div>

                <!-- Modal body -->
                <div class="p-6">
                    <form id="alimenterForm" class="space-y-6">
                        <!-- Sélection du compte -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Compte à alimenter *</label>
                            <select required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Sélectionnez un compte</option>
                                <option value="courant">Compte Courant - FR76 1234 5678 9012 (2,450.50 €)</option>
                                <option value="epargne">Compte Épargne - FR76 9876 5432 1098 (15,750.20 €)</option>
                            </select>
                        </div>

                        <!-- Montant -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Montant *</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">€</span>
                                </div>
                                <input 
                                    type="number" 
                                    required
                                    min="0.01"
                                    step="0.01"
                                    class="w-full pl-8 pr-12 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="0.00"
                                >
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Montant minimum : 0.01 €</p>
                        </div>

                        <!-- Méthode de paiement -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Méthode de paiement *</label>
                            <div class="space-y-3">
                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="paymentMethod" value="carte" class="form-radio text-blue-600" required>
                                    <span class="ml-3">
                                        <span class="block text-sm font-medium text-gray-900">Carte bancaire</span>
                                        <span class="block text-sm text-gray-500">Débit immédiat</span>
                                    </span>
                                </label>

                                <label class="flex items-center p-3 border rounded-lg cursor-pointer hover:bg-gray-50">
                                    <input type="radio" name="paymentMethod" value="virement" class="form-radio text-blue-600">
                                    <span class="ml-3">
                                        <span class="block text-sm font-medium text-gray-900">Virement bancaire</span>
                                        <span class="block text-sm text-gray-500">2-3 jours ouvrés</span>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <!-- Informations carte (affiché conditionnellement) -->
                        <div id="carteInfo" class="space-y-4 border-t pt-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Numéro de carte *</label>
                                <input 
                                    type="text" 
                                    pattern="[0-9]{16}"
                                    maxlength="16"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    placeholder="1234 5678 9012 3456"
                                >
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date d'expiration *</label>
                                    <input 
                                        type="text" 
                                        pattern="(0[1-9]|1[0-2])\/([0-9]{2})"
                                        maxlength="5"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="MM/YY"
                                    >
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">CVV *</label>
                                    <input 
                                        type="text" 
                                        pattern="[0-9]{3}"
                                        maxlength="3"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                        placeholder="123"
                                    >
                                </div>
                            </div>
                        </div>

                        <!-- Message de confirmation -->
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <i data-lucide="info" class="h-5 w-5 text-blue-400"></i>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-blue-700">
                                        Le montant sera crédité sur votre compte selon le mode de paiement choisi.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal footer -->
                <div class="flex justify-end space-x-3 p-6 border-t bg-gray-50">
                    <button 
                        onclick="toggleModal()" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500"
                    >
                        Annuler
                    </button>
                    <button 
                        onclick="submitForm()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                        Confirmer l'alimentation
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        // Gestion de l'affichage des champs de carte
        document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const carteInfo = document.getElementById('carteInfo');
                carteInfo.style.display = this.value === 'carte' ? 'block' : 'none';
            });
        });

        // Fonction pour gérer la soumission du formulaire
        function submitForm() {
            const form = document.getElementById('alimenterForm');
            if (form.checkValidity()) {
                // Traitement du formulaire ici
                alert('Alimentation effectuée avec succès !');
                toggleModal();
            } else {
                form.reportValidity();
            }
        }

        // Fonction pour afficher/masquer le modal
        function toggleModal() {
            const modal = document.getElementById('alimenterCompteModal');
            modal.classList.toggle('hidden');
        }

        // Fermer le modal si on clique en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('alimenterCompteModal');
            if (event.target === modal) {
                toggleModal();
            }
        }
    </script>
</body>
</html>