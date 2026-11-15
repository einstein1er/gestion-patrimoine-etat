@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Localisations</h1>
        <a href="{{ route('localisations.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Nouvelle localisation
        </a>
    </div>

    @if ($localisations->isEmpty())
        <div class="p-6 bg-white rounded shadow">
            Aucune localisation n’a encore été créée.
        </div>
    @else
        <div class="bg-white rounded shadow overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Nom</th>
                        <th class="p-3">Code</th>
                        <th class="p-3">Type</th>
                        <th class="p-3">Parent</th>
                        <th class="p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($localisations as $localisation)
                        <tr class="border-t">
                            <td class="p-3">{{ $localisation->nom }}</td>
                            <td class="p-3">{{ $localisation->code }}</td>
                            <td class="p-3">{{ $localisation->type }}</td>
                            <td class="p-3">{{ $localisation->parent->nom ?? '—' }}</td>
                            <td class="p-3">
                                <a href="{{ route('localisations.show', $localisation) }}" class="text-blue-600 hover:underline">Voir</a>
                                <a href="{{ route('localisations.edit', $localisation) }}" class="text-yellow-600 hover:underline ml-2">Modifier</a>
                                <form action="{{ route('localisations.destroy', $localisation) }}" method="POST" class="inline ml-2"
                                      onsubmit="return confirm('Supprimer cette localisation ?');">
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
            {{ $localisations->links() }}
        </div>
    @endif
</div>
@endsection
