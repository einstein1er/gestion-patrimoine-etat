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
            Aucune maintenance n’a encore été enregistrée.
        </div>
    @else
        <div class="bg-white rounded shadow overflow-hidden">
            <form action="{{ route('maintenances.index') }}" method="GET" class="mb-6 flex gap-3 p-4">
                <input
                    type="text"
                    name="recherche"
                    value="{{ request('recherche') }}"
                    placeholder="Rechercher par bien"
                    class="border rounded p-2 flex-1"
                >

                <select name="statut" class="border rounded p-2">
                    <option value="">Tous les statuts</option>
                    @foreach (['planifiee', 'en_cours', 'terminee', 'annulee'] as $statut)
                        <option value="{{ $statut }}" @selected(request('statut') === $statut)>
                            {{ ucfirst(str_replace('_', ' ', $statut)) }}
                        </option>
                    @endforeach
                </select>

                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Rechercher
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
                        <th class="p-3">Prestataire</th>
                        <th class="p-3">Statut</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($maintenances as $maintenance)
                        <tr class="border-t">
                            <td class="p-3">{{ $maintenance->bien->nom }}</td>
                            <td class="p-3">{{ ucfirst($maintenance->type) }}</td>
                            <td class="p-3">{{ $maintenance->date_maintenance->format('d/m/Y') }}</td>
                            <td class="p-3">{{ number_format($maintenance->cout, 0, ',', ' ') }} FCFA</td>
                            <td class="p-3">{{ $maintenance->prestataire ?? '—' }}</td>
                            <td class="p-3">{{ ucfirst(str_replace('_', ' ', $maintenance->statut)) }}</td>
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

            <div class="p-4">
                {{ $maintenances->links() }}
            </div>
        </div>
    @endif
</div>
@endsection