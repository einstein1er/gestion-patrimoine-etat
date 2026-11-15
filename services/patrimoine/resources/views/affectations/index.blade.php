@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Affectations</h1>
        <a href="{{ route('affectations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nouvelle affectation
        </a>
    </div>

    @if ($affectations->isEmpty())
        <div class="p-6 bg-white rounded shadow">
            Aucune affectation n’a encore été créée.
        </div>
    @else
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Bien</th>
                        <th class="p-3">Localisation</th>
                        <th class="p-3">Début</th>
                        <th class="p-3">Fin</th>
                        <th class="p-3">Responsable</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($affectations as $affectation)
                        <tr class="border-t">
                            <td class="p-3">{{ $affectation->bien->nom }}</td>
                            <td class="p-3">{{ $affectation->localisation->nom }}</td>
                            <td class="p-3">{{ $affectation->date_debut->format('d/m/Y') }}</td>
                            <td class="p-3">{{ $affectation->date_fin?->format('d/m/Y') ?? '—' }}</td>
                            <td class="p-3">{{ $affectation->responsable ?? '—' }}</td>
                            <td class="p-3">
                                <a href="{{ route('affectations.show', $affectation) }}" class="text-blue-600 hover:underline">Voir</a>
                                <a href="{{ route('affectations.edit', $affectation) }}" class="text-yellow-600 hover:underline ml-2">Modifier</a>
                                <form action="{{ route('affectations.destroy', $affectation) }}" method="POST" class="inline ml-2"
                                      onsubmit="return confirm('Supprimer cette affectation ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $affectations->links() }}
        </div>
    @endif
</div>
@endsection
