@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Nouvel utilisateur</h1>

    <form action="{{ route('utilisateurs.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Nom</label>
            <input name="nom" value="{{ old('nom') }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Mot de passe</label>
            <input type="password" name="mot_de_passe" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Confirmation du mot de passe</label>
            <input type="password" name="mot_de_passe_confirmation" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Rôle</label>
            <select name="role" class="w-full border rounded p-2" required>
                <option value="">Choisir un rôle</option>
                @foreach (['administrateur', 'gestionnaire', 'consultant'] as $role)
                    <option value="{{ $role }}" @selected(old('role') === $role)>{{ ucfirst($role) }}</option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="actif" value="1" @checked(old('actif'))>
            <span>Utilisateur actif</span>
        </label>

        <div class="flex gap-3">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Créer</button>
            <a href="{{ route('utilisateurs.index') }}" class="px-4 py-2 border rounded">Annuler</a>
        </div>
    </form>
</div>
@endsection
