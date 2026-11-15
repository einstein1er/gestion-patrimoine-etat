@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Modifier la maintenance</h1>

    <form action="{{ route('maintenances.update', $maintenance) }}" method="POST" class="bg-white p-6 rounded shadow space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block mb-1 font-medium">Bien</label>
            <select name="bien_id" class="w-full border rounded p-2" required>
                @foreach ($biens as $bien)
                    <option value="{{ $bien->id }}" @selected(old('bien_id', $maintenance->bien_id) == $bien->id)>
                        {{ $bien->nom }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Type</label>
            <select name="type" class="w-full border rounded p-2" required>
                @foreach (['preventive', 'corrective', 'reparation', 'inspection'] as $type)
                    <option value="{{ $type }}" @selected(old('type', $maintenance->type) === $type)>
                        {{ ucfirst($type) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Date de maintenance</label>
            <input type="date" name="date_maintenance" value="{{ old('date_maintenance', $maintenance->date_maintenance?->format('Y-m-d')) }}" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Coût</label>
            <input type="number" step="0.01" min="0" name="cout" value="{{ old('cout', $maintenance->cout) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Prestataire</label>
            <input name="prestataire" value="{{ old('prestataire', $maintenance->prestataire) }}" class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block mb-1 font-medium">Statut</label>
            <select name="statut" class="w-full border rounded p-2" required>
                @foreach (['planifiee', 'en_cours', 'terminee', 'annulee'] as $statut)
                    <option value="{{ $statut }}" @selected(old('statut', $maintenance->statut) === $statut)>
                        {{ ucfirst($statut) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1 font-medium">Description</label>
            <textarea name="description" rows="3" class="w-full border rounded p-2">{{ old('description', $maintenance->description) }}</textarea>
        </div>

        <label class="flex items-center gap-2">
            <input type="checkbox" name="actif" value="1" @checked(old('actif', $maintenance->actif))>
            <span>Maintenance active</span>
        </label>

        <div class="flex gap-3">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Modifier</button>
            <a href="{{ route('maintenances.index') }}" class="px-4 py-2 border rounded">Annuler</a>
        </div>
    </form>
</div>
@endsection
