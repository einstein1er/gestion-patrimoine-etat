@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">{{ $localisation->nom }}</h1>

    <div class="bg-white p-6 rounded shadow space-y-2">
        <p><strong>Code :</strong> {{ $localisation->code }}</p>
        <p><strong>Type :</strong> {{ $localisation->type }}</p>
        <p><strong>Parent :</strong> {{ $localisation->parent->nom ?? '—' }}</p>
        <p><strong>Active :</strong> {{ $localisation->actif ? 'Oui' : 'Non' }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('localisations.edit', $localisation) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Modifier</a>
        <a href="{{ route('localisations.index') }}" class="px-4 py-2 border rounded">Retour</a>
    </div>
</div>
@endsection
