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
            <a href="{{ route('categories.index') }}" class="font-semibold">
                Gestion du patrimoine
            </a>
            <nav class="flex gap-4">
                <a href="{{ route('categories.index') }}" class="text-blue-600 hover:underline">
                    Catégories
                </a>
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-6xl px-4 py-8">
        @if (session('succes'))
            <div class="mb-4 rounded border border-green-300 bg-green-50 p-3 text-green-800">
                {{ session('succes') }}
            </div>
        @endif

        @yield('contenu')
    </main>
</body>
</html>
