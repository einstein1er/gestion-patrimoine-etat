@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Affectation</h1>

    <div class="bg-white p-6 rounded shadow space-y-2">
        <p><strong>Bien :</strong> {{ $affectation->bien->nom }}</p>
        <p><strong>Localisation :</strong> {{ $affectation->localisation->nom }}</p>
        <p><strong>Date de début :</strong> {{ $affectation->date_debut->format('d/m/Y') }}</p>
        <p><strong>Date de fin :</strong> {{ $affectation->date_fin?->format('d/m/Y') ?? '—' }}</p>
        <p><strong>Responsable :</strong> {{ $affectation->responsable ?? '—' }}</p>
        <p><strong>Observation :</strong> {{ $affectation->observation ?? '—' }}</p>
        <p><strong>Active :</strong> {{ $affectation->actif ? 'Oui' : 'Non' }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('affectations.edit', $affectation) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Modifier</a>
        <a href="{{ route('affectations.index') }}" class="px-4 py-2 border rounded">Retour</a>
    </div>
</div>
@endsection
