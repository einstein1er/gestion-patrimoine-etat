@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Détail de l’affectation</h1>

    <div class="bg-white p-6 rounded shadow space-y-3">
        <p><span class="font-semibold">Bien :</span> {{ $affectation->bien->nom }}</p>
        <p><span class="font-semibold">Localisation :</span> {{ $affectation->localisation->nom }}</p>
        <p><span class="font-semibold">Date de début :</span> {{ $affectation->date_debut->format('d/m/Y') }}</p>
        <p><span class="font-semibold">Date de fin :</span> {{ $affectation->date_fin?->format('d/m/Y') ?? '—' }}</p>
        <p><span class="font-semibold">Responsable :</span> {{ $affectation->responsable ?? '—' }}</p>
        <p><span class="font-semibold">Observation :</span> {{ $affectation->observation ?? '—' }}</p>
        <p>
            <span class="font-semibold">Statut :</span>
            @if ($affectation->actif)
                <span class="text-green-700">Active</span>
            @else
                <span class="text-red-700">Inactive</span>
            @endif
        </p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('affectations.edit', $affectation) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Modifier
        </a>
        <a href="{{ route('affectations.index') }}" class="px-4 py-2 border rounded">Retour</a>
    </div>
</div>
@endsection