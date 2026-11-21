@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div>
        <h1 class="text-3xl font-bold">Tableau de bord</h1>
        <p class="text-gray-600 mt-1">
            Bienvenue, {{ auth()->user()->nom }}.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Total des biens</p>
            <p class="text-3xl font-bold">{{ $totalBiens }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Valeur totale du patrimoine</p>
            <p class="text-3xl font-bold">{{ number_format($valeurTotale, 0, ',', ' ') }} FCFA</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Coût total des maintenances</p>
            <p class="text-3xl font-bold">{{ number_format($coutMaintenances, 0, ',', ' ') }} FCFA</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Catégories</p>
            <p class="text-3xl font-bold">{{ $totalCategories }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Localisations</p>
            <p class="text-3xl font-bold">{{ $totalLocalisations }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow">
            <p class="text-sm text-gray-500">Affectations</p>
            <p class="text-3xl font-bold">{{ $totalAffectations }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Derniers biens</h2>

            @forelse ($derniersBiens as $bien)
                <div class="border-b py-2">
                    <p class="font-medium">{{ $bien->nom }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $bien->categorie->nom ?? 'Sans catégorie' }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">Aucun bien enregistré.</p>
            @endforelse
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Maintenances récentes</h2>

            @forelse ($dernieresMaintenances as $maintenance)
                <div class="border-b py-2">
                    <p class="font-medium">{{ $maintenance->bien->nom ?? 'Bien supprimé' }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $maintenance->statut }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">Aucune maintenance enregistrée.</p>
            @endforelse
        </div>

        <div class="bg-white p-6 rounded shadow">
            <h2 class="text-lg font-semibold mb-4">Affectations actives</h2>

            @forelse ($affectationsActives as $affectation)
                <div class="border-b py-2">
                    <p class="font-medium">{{ $affectation->bien->nom ?? 'Bien supprimé' }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $affectation->localisation->nom ?? 'Localisation supprimée' }}
                    </p>
                </div>
            @empty
                <p class="text-gray-500">Aucune affectation active.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
