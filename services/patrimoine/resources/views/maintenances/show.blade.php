@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Détail de la maintenance</h1>

    <div class="bg-white p-6 rounded shadow space-y-3">
        <p><span class="font-semibold">Bien :</span> {{ $maintenance->bien->nom }}</p>
        <p><span class="font-semibold">Type :</span> {{ ucfirst($maintenance->type) }}</p>
        <p><span class="font-semibold">Date :</span> {{ $maintenance->date_maintenance->format('d/m/Y') }}</p>
        <p><span class="font-semibold">Coût :</span> {{ number_format($maintenance->cout, 0, ',', ' ') }} FCFA</p>
        <p><span class="font-semibold">Prestataire :</span> {{ $maintenance->prestataire ?? '—' }}</p>
        <p><span class="font-semibold">Description :</span> {{ $maintenance->description ?? '—' }}</p>
        <p><span class="font-semibold">Statut :</span> {{ ucfirst(str_replace('_', ' ', $maintenance->statut)) }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('maintenances.edit', $maintenance) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">
            Modifier
        </a>
        <a href="{{ route('maintenances.index') }}" class="px-4 py-2 border rounded">Retour</a>
    </div>
</div>
@endsection