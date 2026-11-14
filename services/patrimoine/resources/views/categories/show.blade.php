@extends('layouts.app')

@section('contenu')
<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-semibold">{{ $categorie->nom }}</h1>
    <a href="{{ route('categories.index') }}" class="text-blue-600 hover:underline">
        Retour
    </a>
</div>

<div class="rounded-lg border bg-white p-6">
    <p><strong>Code :</strong> {{ $categorie->code }}</p>
    <p><strong>Statut :</strong> {{ $categorie->actif ? 'Active' : 'Inactive' }}</p>
    <p><strong>Description :</strong> {{ $categorie->description ?? 'Aucune description' }}</p>
</div>
@endsection
