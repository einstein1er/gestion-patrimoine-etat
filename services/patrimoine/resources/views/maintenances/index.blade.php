@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Maintenances</h1>
        <a href="{{ route('maintenances.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nouvelle maintenance
        </a>
    </div>

    @if ($maintenances->isEmpty())
        <div class="p-6 bg-white rounded shadow">
            Aucune maintenance n’a encore été créée.
        </div>
    @else
        <div class="bg-white rounded shadow overflow-hidden">
            <form action="{{ route('maintenances.index') }}" method="GET" class="mb-6 flex flex-wrap gap-3">
                <input
                    type="text"
                    name="recherche"
                    value="{{ request('recherche') }}"
                    placeholder="Rechercher une maintenance"
                    class="border rounded p-2 flex-1"
                >

                <select name="statut" class="border rounded p-2">
                    <option value="">Tous les statuts</option>
                    <option value="en_attente" {{ request('statut') === 'en_attente' ? 'selected' : '' }}>En attente</option>
                    <option value="en_cours" {{ request('statut') === 'en_cours' ? 'selected' : '' }}>En cours</option>
                    <option value="terminee" {{ request('statut') === 'terminee' ? 'selected' : '' }}>Terminée</option>
                </select>

                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Filtrer
                </button>

                <a href="{{ route('maintenances.index') }}" class="border px-4 py-2 rounded">
                    Réinitialiser
                </a>
            </form>
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Bien</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">Date</th>
                        <th class="p-3">Coût</th>
                        <th class="p-3">Statut</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($maintenances as $maintenance)
                        <tr class="border-t">
                            <td class="p-3">{{ $maintenance->bien->nom }}</td>
                            <td class="p-3">{{ $maintenance->type }}</td>
                            <td class="p-3">{{ $maintenance->date_maintenance->format('d/m/Y') }}</td>
                            <td class="p-3">{{ number_format($maintenance->cout, 2, ',', ' ') }} FCFA</td>
                            <td class="p-3">{{ $maintenance->statut }}</td>
                            <td class="p-3">
                                <a href="{{ route('maintenances.show', $maintenance) }}" class="text-blue-600 hover:underline">Voir</a>
                                <a href="{{ route('maintenances.edit', $maintenance) }}" class="text-yellow-600 hover:underline ml-2">Modifier</a>
                                <form action="{{ route('maintenances.destroy', $maintenance) }}" method="POST" class="inline ml-2"
                                      onsubmit="return confirm('Supprimer cette maintenance ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $maintenances->links() }}
        </div>

        <div class="mt-4">
            {{ $maintenances->links() }}
        </div>
    @endif
</div>
@endsection
