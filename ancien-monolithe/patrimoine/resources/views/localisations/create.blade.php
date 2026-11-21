@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Nouvelle localisation</h1>

    <form action="{{ route('localisations.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Nom</label>
            <input name="nom" value="{{ old('nom') }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Code</label>
            <input name="code" value="{{ old('code') }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Type</label>
            <select name="type" class="w-full border rounded p-2" required>
                <option value="">Choisir un type</option>
                @foreach (['region', 'province', 'departement', 'commune', 'site'] as $type)
                    <option value="{{ $type }}" @selected(old('type') === $type)>{{ ucfirst($type) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Localisation parente</label>
            <select name="parent_id" class="w-full border rounded p-2">
                <option value="">Aucune</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @selected(old('parent_id') == $parent->id)>
                        {{ $parent->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="actif" value="1" @checked(old('actif'))>
            <span>Localisation active</span>
        </label>

        <div class="flex gap-3">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Créer</button>
            <a href="{{ route('localisations.index') }}" class="px-4 py-2 border rounded">Annuler</a>
        </div>
    </form>
</div>
@endsection
