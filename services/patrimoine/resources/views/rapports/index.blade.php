@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Rapports du patrimoine</h1>
        <a href="{{ route('rapports.pdf') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Exporter en PDF
        </a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600">Total des biens</p>
            <p class="text-2xl font-bold">{{ $totalBiens }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600">Valeur totale</p>
            <p class="text-2xl font-bold">{{ number_format($valeurTotale, 0, ',', ' ') }} FCFA</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600">Coût des maintenances</p>
            <p class="text-2xl font-bold">{{ number_format($coutMaintenances, 0, ',', ' ') }} FCFA</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600">Catégories</p>
            <p class="text-2xl font-bold">{{ $totalCategories }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600">Localisations</p>
            <p class="text-2xl font-bold">{{ $totalLocalisations }}</p>
        </div>

        <div class="bg-white p-4 rounded shadow">
            <p class="text-gray-600">Affectations</p>
            <p class="text-2xl font-bold">{{ $totalAffectations }}</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Biens par catégorie</h2>

            @forelse ($biensParCategorie as $categorie)
                <div class="flex justify-between border-b py-2">
                    <span>{{ $categorie->nom }}</span>
                    <span class="font-semibold">{{ $categorie->biens_count }}</span>
                </div>
            @empty
                <p>Aucune catégorie disponible.</p>
            @endforelse
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Maintenances par statut</h2>

            @forelse ($maintenancesParStatut as $statut => $total)
                <div class="flex justify-between border-b py-2">
                    <span>{{ ucfirst(str_replace('_', ' ', $statut)) }}</span>
                    <span class="font-semibold">{{ $total }}</span>
                </div>
            @empty
                <p>Aucune maintenance disponible.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection