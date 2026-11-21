@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Nouvelle affectation</h1>

    <form action="{{ route('affectations.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf

        <div>
            <label class="block mb-1 font-medium">Bien</label>
            <select name="bien_id" class="w-full border rounded p-2" required>
                <option value="">Choisir un bien</option>
                @foreach ($biens as $bien)
                    <option value="{{ $bien->id }}" @selected(old('bien_id') == $bien->id)>
                        {{ $bien->nom }} ({{ $bien->code }})
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Localisation</label>
            <select name="localisation_id" class="w-full border rounded p-2" required>
                <option value="">Choisir une localisation</option>
                @foreach ($localisations as $localisation)
                    <option value="{{ $localisation->id }}" @selected(old('localisation_id') == $localisation->id)>
                        {{ $localisation->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Date de début</label>
                <input type="date" name="date_debut" value="{{ old('date_debut') }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Date de fin</label>
                <input type="date" name="date_fin" value="{{ old('date_fin') }}" class="w-full border rounded p-2">
            </div>
        </div>

        <div>
            <label class="block mb-1 font-medium">Responsable</label>
            <input name="responsable" value="{{ old('responsable') }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Observation</label>
            <textarea name="observation" rows="4" class="w-full border rounded p-2">{{ old('observation') }}</textarea>
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="actif" value="1" @checked(old('actif', true))>
            <span>Affectation active</span>
        </label>

        <div class="flex gap-3">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Créer</button>
            <a href="{{ route('affectations.index') }}" class="px-4 py-2 border rounded">Annuler</a>
        </div>
    </form>
</div>
@endsection