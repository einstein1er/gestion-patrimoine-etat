@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">{{ $bien->nom }}</h1>

    <div class="bg-white p-6 rounded shadow space-y-2">
        <p><strong>Code :</strong> {{ $bien->code }}</p>
        <p><strong>Catégorie :</strong> {{ $bien->categorie->nom }}</p>
        <p><strong>Description :</strong> {{ $bien->description }}</p>
        <p><strong>Valeur :</strong> {{ number_format($bien->valeur, 2, ',', ' ') }} FCFA</p>
        <p><strong>Date d’acquisition :</strong> {{ $bien->date_acquisition?->format('d/m/Y') }}</p>
        <p><strong>État :</strong> {{ ucfirst($bien->etat) }}</p>
        <p><strong>Localisation :</strong> {{ $bien->localisation }}</p>
        <p><strong>Statut :</strong> {{ $bien->actif ? 'Actif' : 'Inactif' }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('biens.edit', $bien) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Modifier</a>
        <a href="{{ route('biens.index') }}" class="px-4 py-2 rounded border">Retour</a>
    </div>
</div>
@endsection
