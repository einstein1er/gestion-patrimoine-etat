<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion du patrimoine de l’État</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <header class="bg-white border-b">
        <div class="mx-auto max-w-6xl px-4 py-4 flex items-center justify-between">
            <a href="{{ route('rapports.index') }}" class="font-semibold">
                Gestion du patrimoine
            </a>

            <nav class="flex items-center gap-4">
                @auth
                    @if (in_array(auth()->user()->role, ['administrateur', 'gestionnaire']))
                        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:underline">
                            Tableau de bord
                        </a>
                        <a href="{{ route('profil.edit') }}" class="text-blue-600 hover:underline">
                            Mon profil
                        </a>
                        <a href="{{ route('categories.index') }}" class="text-blue-600 hover:underline">
                            Catégories
                        </a>

                        <a href="{{ route('biens.index') }}" class="text-blue-600 hover:underline">
                            Biens
                        </a>

                        <a href="{{ route('localisations.index') }}" class="text-blue-600 hover:underline">
                            Localisations
                        </a>

                        <a href="{{ route('affectations.index') }}" class="text-blue-600 hover:underline">
                            Affectations
                        </a>

                        <a href="{{ route('maintenances.index') }}" class="text-blue-600 hover:underline">
                            Maintenances
                        </a>
                    @endif

                    @if (auth()->user()->role === 'administrateur')
                        <a href="{{ route('utilisateurs.index') }}" class="text-blue-600 hover:underline">
                            Utilisateurs
                        </a>
                    @endif

                    <a href="{{ route('rapports.index') }}" class="text-blue-600 hover:underline">
                        Rapports
                    </a>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button class="text-red-600 hover:underline">
                            Déconnexion
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                        Connexion
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8">
        @if (session('succes'))
                <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-800">
                    {{ session('succes') }}
                </div>
        @endif

        @if (session('erreur'))
                <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-red-800">
                    {{ session('erreur') }}
                </div>
        @endif

        @if ($errors->any())
                <div class="mb-4 rounded border border-yellow-300 bg-yellow-50 p-3 text-yellow-800">
                    <p class="font-semibold mb-1">Veuillez corriger les erreurs suivantes :</p>
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $erreur)
                            <li>{{ $erreur }}</li>
                        @endforeach
                    </ul>
                </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
