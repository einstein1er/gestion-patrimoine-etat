@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold mb-6">Rapports du patrimoine</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-500">Total des biens</p>
            <p class="text-3xl font-bold">{{ $totalBiens }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-500">Valeur totale</p>
            <p class="text-3xl font-bold">{{ number_format($valeurTotale, 2, ',', ' ') }} FCFA</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-500">Coût des maintenances</p>
            <p class="text-3xl font-bold">{{ number_format($coutMaintenances, 2, ',', ' ') }} FCFA</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-500">Catégories</p>
            <p class="text-3xl font-bold">{{ $totalCategories }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-500">Localisations</p>
            <p class="text-3xl font-bold">{{ $totalLocalisations }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-gray-500">Affectations</p>
            <p class="text-3xl font-bold">{{ $totalAffectations }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-bold mb-4">Biens par catégorie</h2>

            @if ($biensParCategorie->isEmpty())
                <p>Aucune catégorie disponible.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($biensParCategorie as $categorie)
                        <li class="flex justify-between border-b pb-2">
                            <span>{{ $categorie->nom }}</span>
                            <span class="font-semibold">{{ $categorie->biens_count }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-bold mb-4">Maintenances par statut</h2>

            @if ($maintenancesParStatut->isEmpty())
                <p>Aucune maintenance disponible.</p>
            @else
                <ul class="space-y-2">
                    @foreach ($maintenancesParStatut as $statut => $total)
                        <li class="flex justify-between border-b pb-2">
                            <span>{{ ucfirst($statut) }}</span>
                            <span class="font-semibold">{{ $total }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
