@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Détail de l’utilisateur</h1>

    <div class="bg-white p-6 rounded shadow space-y-3">
        <p><span class="font-semibold">Nom :</span> {{ $utilisateur->nom }}</p>
        <p><span class="font-semibold">Email :</span> {{ $utilisateur->email }}</p>
        <p><span class="font-semibold">Rôle :</span> {{ ucfirst($utilisateur->role) }}</p>
        <p>
            <span class="font-semibold">Statut :</span>
            @if ($utilisateur->actif)
                <span class="text-green-700">Actif</span>
            @else
                <span class="text-red-700">Inactif</span>
            @endif
        </p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('utilisateurs.edit', $utilisateur) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Modifier
        </a>
        <a href="{{ route('utilisateurs.index') }}" class="px-4 py-2 border rounded">Retour</a>
    </div>
</div>
@endsection