<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport du patrimoine</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1 { font-size: 20px; margin-bottom: 4px; }
        h2 { font-size: 15px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }
        th { background: #f3f4f6; }
        .total { font-weight: bold; }
    </style>
</head>
<body>
    <h1>Rapport du patrimoine de l’État</h1>
    <p>Date de génération : {{ now()->format('d/m/Y H:i') }}</p>

    <h2>Indicateurs généraux</h2>
    <table>
        <tr>
            <th>Indicateur</th>
            <th>Valeur</th>
        </tr>
        <tr>
            <td>Total des biens</td>
            <td>{{ $totalBiens }}</td>
        </tr>
        <tr>
            <td>Valeur totale des biens</td>
            <td>{{ number_format($valeurTotale, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <td>Coût total des maintenances</td>
            <td>{{ number_format($coutMaintenances, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <td>Total des catégories</td>
            <td>{{ $totalCategories }}</td>
        </tr>
        <tr>
            <td>Total des localisations</td>
            <td>{{ $totalLocalisations }}</td>
        </tr>
        <tr>
            <td>Total des affectations</td>
            <td>{{ $totalAffectations }}</td>
        </tr>
    </table>

    <h2>Répartition des biens par catégorie</h2>
    <table>
        <thead>
            <tr>
                <th>Catégorie</th>
                <th>Nombre de biens</th>
                <th>Valeur totale</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($repartitionCategories as $ligne)
                <tr>
                    <td>{{ $ligne->nom }}</td>
                    <td>{{ $ligne->total }}</td>
                    <td>{{ number_format($ligne->valeur, 0, ',', ' ') }} FCFA</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Aucune donnée disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Répartition des maintenances par statut</h2>
    <table>
        <thead>
            <tr>
                <th>Statut</th>
                <th>Nombre</th>
                <th>Coût total</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($repartitionMaintenances as $ligne)
                <tr>
                    <td>{{ ucfirst(str_replace('_', ' ', $ligne->statut)) }}</td>
                    <td>{{ $ligne->total }}</td>
                    <td>{{ number_format($ligne->cout, 0, ',', ' ') }} FCFA</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Aucune donnée disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h2>Derniers biens enregistrés</h2>
    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Code</th>
                <th>Catégorie</th>
                <th>Valeur</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($derniersBiens as $bien)
                <tr>
                    <td>{{ $bien->nom }}</td>
                    <td>{{ $bien->code }}</td>
                    <td>{{ $bien->categorie->nom ?? '—' }}</td>
                    <td>{{ number_format($bien->valeur, 0, ',', ' ') }} FCFA</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Aucun bien disponible.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>