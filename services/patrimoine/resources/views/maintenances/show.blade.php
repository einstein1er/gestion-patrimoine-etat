@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Maintenance</h1>

    <div class="bg-white p-6 rounded shadow space-y-2">
        <p><strong>Bien :</strong> {{ $maintenance->bien->nom }}</p>
        <p><strong>Type :</strong> {{ $maintenance->type }}</p>
        <p><strong>Date :</strong> {{ $maintenance->date_maintenance->format('d/m/Y') }}</p>
        <p><strong>Coût :</strong> {{ number_format($maintenance->cout, 2, ',', ' ') }} FCFA</p>
        <p><strong>Prestataire :</strong> {{ $maintenance->prestataire ?? '—' }}</p>
        <p><strong>Statut :</strong> {{ $maintenance->statut }}</p>
        <p><strong>Description :</strong> {{ $maintenance->description ?? '—' }}</p>
        <p><strong>Active :</strong> {{ $maintenance->actif ? 'Oui' : 'Non' }}</p>
    </div>

    <div class="mt-6 flex gap-3">
        <a href="{{ route('maintenances.edit', $maintenance) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Modifier</a>
        <a href="{{ route('maintenances.index') }}" class="px-4 py-2 border rounded">Retour</a>
    </div>
</div>
@endsection
