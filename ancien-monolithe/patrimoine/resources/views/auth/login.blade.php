@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Connexion</h1>

    <form action="{{ route('login.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded p-2" required>
            @error('email')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block mb-1 font-medium">Mot de passe</label>
            <input type="password" name="mot_de_passe" class="w-full border rounded p-2" required>
        </div>

        <button class="w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Se connecter
        </button>
    </form>
</div>
@endsection
