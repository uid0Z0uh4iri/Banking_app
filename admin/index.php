
<!DOCTYPE html>
<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
   Dashboard
  </title>
  <script src="https://cdn.tailwindcss.com">
  </script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
 
 </head>
 <body class="bg-gray-100 font-sans antialiased">
  <div class="flex">
   <!-- Sidebar -->
   <div class="w-64 bg-blue-900 text-white min-h-screen">
    <div class="p-4 flex items-center">
     <span class="ml-3 text-xl font-semibold">
      <span class="text-blue-200">Admin</span> Dashbord
     </span>
    </div>
    <nav class="mt-5">
        <div class="mt-5">
            <a class="flex items-center p-3 hover:bg-blue-800 rounded-lg" href="">
            <!-- <i class="fas fa-book"></i> -->
            <i class="fas fa-home"></i>
            </i>
            <span class="ml-3">
            bibliotheque
            </span>
            </a>
        </div>
        
     <div class="mt-5">
  
      <a class="flex items-center p-3 hover:bg-blue-800 rounded-lg" href="">
        
       <i class="fas fa-book"></i>
       </i>
       <span class="ml-3">
        Gestion des Livres
       </span>
      </a>
     </div>
     <div class="mt-5">
      <a class="flex items-center p-3 hover:bg-blue-800 rounded-lg" href="">
       <!-- <i class="fas fa-edit"> -->
       <i class="fas fa-filter"></i>
       </i>
       <span class="ml-3">
        Gestion des categories 
       </span>
      </a>
   
     </div>
     <div class="mt-5">
      <a class="flex items-center p-3 hover:bg-blue-800 rounded-lg" href="">
      <i class="fas fa-file-pdf"></i>
       </i>
       <span class="ml-3">
        statistiques et rapports 
       </span>
      </a>
   
     </div>
  
        <div class="mt-5">
        <a href="../logout.php" class="flex items-center p-3 hover:bg-blue-800 rounded-lg text-red-500 hover:text-red-400">
            <i class="fas fa-sign-out-alt"></i>
            <span class="ml-3">
                Déconnexion
            </span>
        </a>
        </div>
    </nav>
   </div>
   <!-- Main Content -->
   <div class="flex-1 p-6">
    <div class="flex justify-between items-center mb-6">
     <h1 class="text-2xl font-semibold text-blue-500">
      Dashboard
     </h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-6">
     <div class="bg-white p-4 rounded-lg shadow">
      <div class="flex items-center justify-between">
       <div>
        <p class="text-gray-600">
         Total des utilisateurs
        </p>
        <p class="text-2xl font-semibold text-blue-500">
  
        </p>
       </div>
       <i class="fas fa-user text-blue-500"></i>
      </div>
      <div class="mt-4">
       <div class="h-2 bg-blue-500 rounded-full" style="width: 100%;">
       </div>
      </div>
     </div>
     <div class="bg-white p-4 rounded-lg shadow">
      <div class="flex items-center justify-between">
       <div>
        <p class="text-gray-600">Total des livres</p>
        <p class="text-2xl font-semibold text-blue-500">
            </p>
       </div>
       <i class="fas fa-university text-blue-500"></i>
    
      </div>
      <div class="mt-4">
       <div class="h-2 bg-blue-500 rounded-full" style="width: 100%;"></div>
      </div>
     </div>
     <div class="bg-white p-4 rounded-lg shadow">
      <div class="flex items-center justify-between">
       <div>
        <p class="text-gray-600">
         Categories
        </p>
        <p class="text-2xl font-semibold text-blue-500">
         
        </p>
       </div>
      
       <i class="fas fa-bookmark text-blue-500"></i>
       </i>
      </div>
      <div class="mt-4">
       <div class="h-2 bg-blue-500 rounded-full" style="width: 100%;">
       </div>
      </div>
     </div>
     <div class="bg-white p-4 rounded-lg shadow">
      <div class="flex items-center justify-between">
       <div>
        <p class="text-gray-600">
         Livres réservé
        </p>
        <p class="text-2xl font-semibold text-blue-500">
         
        </p>
       </div>
     
       <i class="fas fa-book text-blue-500"></i>
       </i>
      </div>
      <div class="mt-4">
       <div class="h-2 bg-blue-500 rounded-full" style="width: 100%;">
       </div>
      </div>
     </div>
     <div class="bg-white p-4 rounded-lg shadow">
      <div class="flex items-center justify-between">
       <div>
        <p class="text-gray-600">
         Livres emprientés
        </p>
        <p class="text-2xl font-semibold text-blue-500">
         
        </p>
       </div>
       
       <i class="fas fa-book-open text-blue-500"></i>
       </i>
      </div>
      <div class="mt-4">
       <div class="h-2 bg-blue-500 rounded-full" style="width: 100%;">
       </div>
      </div>
     </div>
  


    </div>
    <div class="bg-white p-6 rounded-lg shadow mb-6">
     <h2 class="text-xl font-semibold mb-4">Utilisateurs</h2>
     <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Nom
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Email
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Role
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date d'inscription
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            
                               
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                       
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-2">
                                <div class="flex space-x-2">
                                    <form method="GET" action="edit_user.php" style="display: inline;">
                                        <input type="hidden" name="id" value="">
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">
                                            Modifier
                                        </button>
                                    </form>

                                    
                                        <form method="POST" action="delete_user.php" style="display: inline;">
                                            <input type="hidden" name="id" value="">
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded" 
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">
                                                Supprimer
                                            </button>
                                        </form>
                                    
                                </div>
                                
                                
                                    <form method="POST" style="display: inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir changer le rôle de cet utilisateur ?');">
                                        <input type="hidden" name="userId" value="">
                                        <select name="newRole" onchange="this.form.submit()" class="w-22 bg-gray-100 border border-gray-300 rounded px-1 py-1">
                                            <option value="authenticated">Authenticated</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </form>
                               
                            </div>
                        </td>
                    </tr>
               
            </tbody>
        </table>
    </div>
    </div>
   </div>
  </div>
  <!-- Notification -->
  <div id="notification" class="fixed top-4 right-4 px-4 py-2 rounded-lg shadow-lg transform transition-all duration-300 opacity-0 translate-y-[-100%]">
  </div>

  
 </body>
</html>
