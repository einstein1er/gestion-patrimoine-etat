@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto space-y-8">
    <h1 class="text-3xl font-bold">Mon profil</h1>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Informations personnelles</h2>

        <form action="{{ route('profil.informations') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium">Nom</label>
                <input
                    type="text"
                    name="nom"
                    value="{{ old('nom', $utilisateur->nom) }}"
                    class="w-full border rounded p-2"
                    required
                >
                @error('nom')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Email</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $utilisateur->email) }}"
                    class="w-full border rounded p-2"
                    required
                >
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Rôle</label>
                <input
                    type="text"
                    value="{{ ucfirst($utilisateur->role) }}"
                    class="w-full border rounded p-2 bg-gray-100"
                    disabled
                >
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Mettre à jour mes informations
            </button>
        </form>
    </div>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-lg font-semibold mb-4">Changer mon mot de passe</h2>

        <form action="{{ route('profil.mot-de-passe') }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block mb-1 font-medium">Mot de passe actuel</label>
                <input
                    type="password"
                    name="mot_de_passe_actuel"
                    class="w-full border rounded p-2"
                    required
                >
                @error('mot_de_passe_actuel')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Nouveau mot de passe</label>
                <input
                    type="password"
                    name="mot_de_passe"
                    class="w-full border rounded p-2"
                    required
                >
                @error('mot_de_passe')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Confirmer le nouveau mot de passe</label>
                <input
                    type="password"
                    name="mot_de_passe_confirmation"
                    class="w-full border rounded p-2"
                    required
                >
            </div>

            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Changer mon mot de passe
            </button>
        </form>
    </div>
</div>
@endsection
