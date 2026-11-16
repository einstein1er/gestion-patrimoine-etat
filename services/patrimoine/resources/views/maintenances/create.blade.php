@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Nouvelle maintenance</h1>

    <form action="{{ route('maintenances.store') }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
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
            <label class="block mb-1 font-medium">Type de maintenance</label>
            <select name="type" class="w-full border rounded p-2" required>
                <option value="">Choisir un type</option>
                @foreach (['preventive', 'corrective', 'reparation', 'inspection'] as $type)
                    <option value="{{ $type }}" @selected(old('type') === $type)>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-1 font-medium">Date de maintenance</label>
                <input type="date" name="date_maintenance" value="{{ old('date_maintenance') }}" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Coût (FCFA)</label>
                <input type="number" step="0.01" min="0" name="cout" value="{{ old('cout') }}" class="w-full border rounded p-2">
            </div>
        </div>

        <div>
            <label class="block mb-1 font-medium">Prestataire</label>
            <input name="prestataire" value="{{ old('prestataire') }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded p-2">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="block mb-1 font-medium">Statut</label>
            <select name="statut" class="w-full border rounded p-2" required>
                <option value="">Choisir un statut</option>
                @foreach (['planifiee', 'en_cours', 'terminee', 'annulee'] as $statut)
                    <option value="{{ $statut }}" @selected(old('statut') === $statut)>
                        {{ ucfirst(str_replace('_', ' ', $statut)) }}
                    </option>
                @endforeach
            </select>
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="actif" value="1" @checked(old('actif', true))>
            <span>Maintenance active</span>
        </label>

        <div class="flex gap-3">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Créer</button>
            <a href="{{ route('maintenances.index') }}" class="px-4 py-2 border rounded">Annuler</a>
        </div>
    </form>
</div>
@endsection