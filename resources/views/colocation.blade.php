<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>EasyColoc</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    @include('includes.header')

    <div class="flex">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md h-screen flex flex-col">
            <div class="p-6 text-xl font-bold text-blue-600">EasyColoc</div>
            <nav class="flex-1">
                <ul class="space-y-2 px-4">
                    <li><a href="#" class="block py-2 px-3 rounded hover:bg-blue-100">Dashboard</a></li>
                    <li><a href="#" class="block py-2 px-3 rounded hover:bg-blue-100">Colocations</a></li>
                    <li><a href="#" class="block py-2 px-3 rounded hover:bg-blue-100">Admin</a></li>
                    <li><a href="#" class="block py-2 px-3 rounded hover:bg-blue-100">Profile</a></li>
                </ul>
            </nav>
            <div class="px-4 py-2 text-sm text-gray-600">Votre réputation: <span class="font-semibold">+0 points</span>
            </div>
            <button class="m-4 py-2 px-3 bg-red-500 text-white rounded hover:bg-red-600">Déconnexion</button>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Top bar -->
            <div class="flex justify-between items-center mb-6">
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">'{{ $name }}' créée.</div>
                <div class="text-sm font-semibold text-gray-700"> Hello {{ auth()->user()->firstname }}</div>
            </div>

            <!-- Dépenses récentes -->
            <section class="bg-white shadow rounded p-4 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Dépenses récentes</h2>
                </div>
                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 text-left">Titre / Catégorie</th>
                            <th class="p-2 text-left">Payeur</th>
                            <th class="p-2 text-left">Montant</th>
                            <th class="p-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="4" class="text-center text-gray-500 py-4">Aucune dépense pour le moment.</td>
                        </tr>
                    </tbody>
                </table>
                <button class="mt-4 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600">+ Nouvelle
                    dépense</button>
            </section>

            <!-- Qui doit à qui -->
            <section class="bg-white shadow rounded p-4 mb-6">
                <h2 class="text-lg font-semibold mb-2">Qui doit à qui ?</h2>
                <p class="text-gray-500">Aucun remboursement en attente.</p>
            </section>

            <!-- Membres -->
            <section class="bg-white shadow rounded p-4">
                <h2 class="text-lg font-semibold mb-4">Membres de la coloc</h2>
                <ul class="space-y-2">
                    <li class="flex justify-between items-center border-b pb-2">
                        <span>👑 admin <span class="text-xs text-gray-500">(OWNER)</span></span>
                        <span class="text-sm text-gray-700">Balance: 0</span>
                    </li>
                </ul>
                <button class="mt-4 py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600">Inviter un
                    membre</button>
            </section>
        </main>
    </div>

    @include('includes.footer')
</body>

</html>