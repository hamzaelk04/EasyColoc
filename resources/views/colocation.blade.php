<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
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
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded">'{{ $colocation->name }}' créée.</div>
                <div class="text-sm font-semibold text-gray-700"> Hello {{ auth()->user()->firstname }}</div>
            </div>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Dépenses récentes -->
            <section class="bg-white shadow rounded p-4 mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Dépenses récentes</h2>
                </div>
                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 text-center">Titre / Catégorie</th>
                            <th class="p-2 text-center">Payeur</th>
                            <th class="p-2 text-center">Montant</th>
                            <th class="p-2 text-center">date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($expenses->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-gray-500 py-4">Aucune dépense pour le moment.</td>
                            </tr>
                        @else
                            @foreach ($expenses as $expense)
                                <tr>
                                    <td class="text-center py-4">{{ $expense->title }}</td>
                                    <td class="text-center py-4">{{ $expense->payer->firstname }}</td>
                                    <td class="text-center py-4">{{ $expense->amount }}</td>
                                    <td class="text-center py-4">{{ $expense->date }}</td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                <button onclick="openModal()" class="mt-4 py-2 px-4 bg-blue-500 text-white rounded hover:bg-blue-600">+
                    Nouvelle
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
                    @foreach ($users as $user)
                        <li class="flex justify-between items-center border-b pb-2">
                            <span> {{ $user->firstname }} <span
                                    class="text-xs text-gray-500">({{ $user->pivot->role }})</span></span>
                            <span class="text-sm text-gray-700">Balance: 0</span>
                        </li>
                    @endforeach
                </ul>
                <button onclick="openInviteModal()"
                    class="mt-4 py-2 px-4 bg-green-500 text-white rounded hover:bg-green-600">
                    Inviter un membre
                </button>
            </section>
        </main>
    </div>

    @include('includes.footer')

    <!-- Modal Overlay -->
    <div id="expenseModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">

            <!-- Close Button -->
            <button onclick="closeModal()" class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">
                &times;
            </button>

            <h2 class="text-lg font-semibold mb-4">Nouvelle dépense</h2>

            <form method="POST" action="{{ route('expense.store', $colocation->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Titre</label>
                    <input type="text" name="title"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Date</label>
                    <input type="text" name="date"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Montant</label>
                    <input type="number" name="amount"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                        Annuler
                    </button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                        Enregistrer
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Invitation Modal -->
    <div id="inviteModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6 relative">
            <!-- Close Button -->
            <button onclick="closeInviteModal()"
                class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 text-xl">
                &times;
            </button>

            <h2 class="text-lg font-semibold mb-4">Inviter un membre</h2>

            <form method="POST" action="{{ route('colocation.invite', $colocation->id) }}">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Email du membre</label>
                    <input type="email" name="email" required
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                        placeholder="exemple@domaine.com">
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeInviteModal()"
                        class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">Annuler</button>
                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                        Envoyer l'invitation
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById('expenseModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('expenseModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openInviteModal() {
            const modal = document.getElementById('inviteModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeInviteModal() {
            const modal = document.getElementById('inviteModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    </script>
</body>

</html>