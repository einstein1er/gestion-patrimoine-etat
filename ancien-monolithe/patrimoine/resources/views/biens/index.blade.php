@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Biens</h1>
        <a href="{{ route('biens.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nouveau bien
        </a>
    </div>

    @if (session('succes'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
            {{ session('succes') }}
        </div>
    @endif

    @if ($biens->isEmpty())
        <div class="p-6 bg-white rounded shadow">
            Aucun bien n’a encore été créé.
        </div>
    @else
        <div class="bg-white rounded shadow overflow-hidden">
            <form action="{{ route('biens.index') }}" method="GET" class="mb-6 flex flex-wrap gap-3">
                <input
                    type="text"
                    name="recherche"
                    value="{{ request('recherche') }}"
                    placeholder="Rechercher un bien"
                    class="border rounded p-2 flex-1"
                >

                <select name="categorie" class="border rounded p-2">
                    <option value="">Toutes les catégories</option>
                    @foreach ($categories as $categorie)
                        <option value="{{ $categorie->id }}" {{ request('categorie') == $categorie->id ? 'selected' : '' }}>
                            {{ $categorie->nom }}
                        </option>
                    @endforeach
                </select>

                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Filtrer
                </button>

                <a href="{{ route('biens.index') }}" class="border px-4 py-2 rounded">
                    Réinitialiser
                </a>
            </form>
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Nom</th>
                        <th class="p-3">Code</th>
                        <th class="p-3">Catégorie</th>
                        <th class="p-3">Valeur</th>
                        <th class="p-3">État</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($biens as $bien)
                        <tr class="border-t">
                            <td class="p-3">{{ $bien->nom }}</td>
                            <td class="p-3">{{ $bien->code }}</td>
                            <td class="p-3">{{ $bien->categorie->nom }}</td>
                            <td class="p-3">{{ number_format($bien->valeur, 2, ',', ' ') }} FCFA</td>
                            <td class="p-3">{{ $bien->etat }}</td>
                            <td class="p-3">
                                <a href="{{ route('biens.show', $bien) }}" class="text-blue-600 hover:underline">Voir</a>
                                <a href="{{ route('biens.edit', $bien) }}" class="text-yellow-600 hover:underline ml-2">Modifier</a>
                                <form action="{{ route('biens.destroy', $bien) }}" method="POST" class="inline ml-2"
                                      onsubmit="return confirm('Supprimer ce bien ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $biens->links() }}
        </div>

        <div class="mt-4">
            {{ $biens->links() }}
        </div>
    @endif
</div>
@endsection
