@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Modifier le bien</h1>

    <form action="{{ route('biens.update', $bien) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Catégorie</label>
            <select name="categorie_id" required class="w-full border rounded p-2">
                @foreach ($categories as $categorie)
                    <option value="{{ $categorie->id }}" @selected($bien->categorie_id === $categorie->id)>
                        {{ $categorie->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Nom</label>
            <input type="text" name="nom" value="{{ old('nom', $bien->nom) }}" required class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Code</label>
            <input type="text" name="code" value="{{ old('code', $bien->code) }}" required class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description', $bien->description) }}</textarea>
        </div>

        <div>
            <label class="block mb-1 font-medium">Valeur (FCFA)</label>
            <input type="number" name="valeur" step="0.01" min="0" value="{{ old('valeur', $bien->valeur) }}" required class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Date d’acquisition</label>
            <input type="date" name="date_acquisition" value="{{ old('date_acquisition', $bien->date_acquisition?->format('Y-m-d')) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">État</label>
            <select name="etat" required class="w-full border rounded p-2">
                @foreach (['neuf', 'bon', 'moyen', 'mauvais'] as $etat)
                    <option value="{{ $etat }}" @selected($bien->etat === $etat)>{{ ucfirst($etat) }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Localisation</label>
            <input type="text" name="localisation" value="{{ old('localisation', $bien->localisation) }}" class="w-full border rounded p-2">
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="actif" value="1" @checked(old('actif', $bien->actif))>
            Actif
        </label>

        <div class="flex gap-3">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mettre à jour</button>
            <a href="{{ route('biens.index') }}" class="px-4 py-2 rounded border">Annuler</a>
        </div>
    </form>
</div>
@endsection
