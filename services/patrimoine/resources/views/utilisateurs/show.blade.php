@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">{{ $utilisateur->nom }}</h1>

    <div class="bg-white p-6 rounded shadow space-y-2">
        <p><strong>Email :</strong> {{ $utilisateur->email }}</p>
        <p><strong>Rôle :</strong> {{ ucfirst($utilisateur->role) }}</p>
        <p><strong>Statut :</strong> {{ $utilisateur->actif ? 'Actif' : 'Inactif' }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Modifier</a>
        <a href="{{ route('utilisateurs.index') }}" class="px-4 py-2 border rounded">Retour</a>
    </div>
</div>
@endsection
