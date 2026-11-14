@extends('layouts.app')

@section('contenu')
<h1 class="mb-6 text-2xl font-semibold">Modifier la catégorie</h1>

<form action="{{ route('categories.update', $categorie) }}"
      method="POST"
      class="max-w-xl space-y-4 rounded-lg border bg-white p-6">
    @csrf
    @method('PUT')

    <div>
        <label for="nom" class="mb-1 block text-sm font-medium">Nom</label>
        <input id="nom" name="nom" type="text" value="{{ old('nom', $categorie->nom) }}"
               class="w-full rounded border border-gray-300 px-3 py-2">
        @error('nom')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="code" class="mb-1 block text-sm font-medium">Code</label>
        <input id="code" name="code" type="text" value="{{ old('code', $categorie->code) }}"
               class="w-full rounded border border-gray-300 px-3 py-2">
        @error('code')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="description" class="mb-1 block text-sm font-medium">Description</label>
        <textarea id="description" name="description" rows="4"
                  class="w-full rounded border border-gray-300 px-3 py-2">{{ old('description', $categorie->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="actif" class="mb-1 block text-sm font-medium">Statut</label>
        <select id="actif" name="actif"
                class="w-full rounded border border-gray-300 px-3 py-2">
            <option value="1" @selected(old('actif', $categorie->actif))>Active</option>
            <option value="0" @selected(old('actif') === '0')>Inactive</option>
        </select>
        @error('actif')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-3">
        <button type="submit"
                class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Mettre à jour
        </button>
        <a href="{{ route('categories.index') }}"
           class="rounded border px-4 py-2 hover:bg-gray-50">
            Annuler
        </a>
    </div>
</form>
@endsection
