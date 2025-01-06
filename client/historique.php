<!DOCTYPE html>
<html lang="fr">
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
                <h1 class="text-2xl font-bold text-blue-600">Ma Banque</h1>
            </div>
            <nav class="mt-6">
                <a href="index.html" class="flex items-center w-full p-4 space-x-3 bg-blue-50 text-blue-600 border-r-4 border-blue-600">
                    <i data-lucide="wallet"></i>
                    <span>Tableau de bord</span>
                </a>
                <a href="mcompte.html" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="credit-card"></i>
                    <span>Mes comptes</span>
                </a>
                <a href="virement.html" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="send"></i>
                    <span>Virements</span>
                </a>
                <a href="benificier.html" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="users"></i>
                    <span>Bénéficiaires</span>
                </a>
                <a href="historique.html" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="history"></i>
                    <span>Historique</span>
                </a>
                <a href="profeil.html" class="flex items-center w-full p-4 space-x-3 text-gray-600 hover:bg-gray-50">
                    <i data-lucide="user"></i>
                    <span>Profil</span>
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
                            <option value="custom">Période personnalisée</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type d'opération</label>
                        <select class="w-full rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500">
                            <option value="all">Toutes les opérations</option>
                            <option value="credit">Crédit uniquement</option>
                            <option value="debit">Débit uniquement</option>
                            <option value="transfer">Virements</option>
                            <option value="payment">Paiements</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Montant</label>
                        <div class="flex space-x-2">
                            <input 
                                type="number" 
                                placeholder="Min"
                                class="w-1/2 rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500"
                            />
                            <input 
                                type="number" 
                                placeholder="Max"
                                class="w-1/2 rounded-md border border-gray-300 px-3 py-2 focus:border-blue-500 focus:ring-blue-500"
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
                    <button class="mb-2 md:mb-0 px-4 py-2 text-gray-700 bg-gray-100 rounded-md hover:bg-gray-200">
                        Réinitialiser
                    </button>
                    <button class="px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700">
                        Appliquer les filtres
                    </button>
                </div>
            </div>

            <!-- Résumé -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total des entrées</h3>
                    <p class="text-2xl font-bold text-green-600 mt-2">+ 3,450.50 €</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Total des sorties</h3>
                    <p class="text-2xl font-bold text-red-600 mt-2">- 2,180.30 €</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-sm font-medium text-gray-500">Solde de la période</h3>
                    <p class="text-2xl font-bold text-blue-600 mt-2">+ 1,270.20 €</p>
                </div>
            </div>

            <!-- Liste des transactions -->
          <!-- Liste des transactions -->
<div class="bg-white rounded-lg shadow mt-6">
    <div class="p-4 md:p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-700">Transactions</h3>
            <button class="text-blue-600 hover:text-blue-800 flex items-center">
                <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                Exporter
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Date
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Libellé
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Type
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Compte
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Montant
                        </th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Transaction 1 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            15 Jan 2025
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div>Virement à John Doe</div>
                            <div class="text-gray-500">Remboursement restaurant</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                Virement
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Compte Courant
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-red-600">
                            - 125.00 €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <button class="text-blue-600 hover:text-blue-900">
                                Détails
                            </button>
                        </td>
                    </tr>

                    <!-- Transaction 2 -->
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            14 Jan 2025
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-900">
                            <div>Salaire Entreprise XYZ</div>
                            <div class="text-gray-500">Salaire Janvier 2025</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Virement reçu
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            Compte Courant
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-medium text-green-600">
                            + 2,500.00 €
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                            <button class="text-blue-600 hover:text-blue-900">
                                Détails
                            </button>
                        </td>
                    </tr>

                    <!-- Plus de transactions... -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="flex items-center justify-between mt-6 flex-col md:flex-row">
            <div class="text-sm text-gray-700 mb-2 md:mb-0">
                Affichage de 1 à 10 sur 56 transactions
            </div>
            <div class="flex space-x-2">
                <button class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-50">
                    Précédent
                </button>
                <button class="px-3 py-1 border bg-blue-50 text-blue-600 rounded">
                    1
                </button>
                <button class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-50">
                    2
                </button>
                <button class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-50">
                    3
                </button>
                <button class="px-3 py-1 border rounded text-gray-600 hover:bg-gray-50">
                    Suivant
                </button>
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