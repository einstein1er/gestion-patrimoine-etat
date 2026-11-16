<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Rapport du patrimoine de l’État</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h1 {
            text-align: center;
            margin-bottom: 5px;
        }

        .date {
            text-align: center;
            color: #555;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #999;
            padding: 6px;
            text-align: left;
        }

        th {
            background: #eee;
        }

        h2 {
            margin-top: 25px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <h1>Rapport du patrimoine de l’État</h1>
    <p class="date">Généré le {{ now()->format('d/m/Y à H:i') }}</p>

    <h2>Statistiques générales</h2>
    <table>
        <tr>
            <th>Total des biens</th>
            <td>{{ $totalBiens }}</td>
        </tr>
        <tr>
            <th>Valeur totale du patrimoine</th>
            <td>{{ number_format($valeurTotale, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <th>Coût total des maintenances</th>
            <td>{{ number_format($coutMaintenances, 0, ',', ' ') }} FCFA</td>
        </tr>
        <tr>
            <th>Nombre de catégories</th>
            <td>{{ $totalCategories }}</td>
        </tr>
        <tr>
            <th>Nombre de localisations</th>
            <td>{{ $totalLocalisations }}</td>
        </tr>
        <tr>
            <th>Nombre d’affectations</th>
            <td>{{ $totalAffectations }}</td>
        </tr>
    </table>

    <h2>Répartition des biens par catégorie</h2>
    <table>
        <tr>
            <th>Catégorie</th>
            <th>Nombre de biens</th>
            <th>Valeur totale</th>
        </tr>
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
    </table>

    <h2>Répartition des maintenances par statut</h2>
    <table>
        <tr>
            <th>Statut</th>
            <th>Nombre</th>
            <th>Coût total</th>
        </tr>
        @forelse ($repartitionMaintenances as $ligne)
            <tr>
                <td>{{ $ligne->statut }}</td>
                <td>{{ $ligne->total }}</td>
                <td>{{ number_format($ligne->cout, 0, ',', ' ') }} FCFA</td>
            </tr>
        @empty
            <tr>
                <td colspan="3">Aucune donnée disponible.</td>
            </tr>
        @endforelse
    </table>

    <h2>Derniers biens enregistrés</h2>
    <table>
        <tr>
            <th>Nom</th>
            <th>Référence</th>
            <th>Catégorie</th>
            <th>Valeur</th>
        </tr>
        @forelse ($derniersBiens as $bien)
            <tr>
                <td>{{ $bien->nom }}</td>
                <td>{{ $bien->reference }}</td>
                <td>{{ $bien->categorie->nom ?? 'Sans catégorie' }}</td>
                <td>{{ number_format($bien->valeur, 0, ',', ' ') }} FCFA</td>
            </tr>
        @empty
            <tr>
                <td colspan="4">Aucun bien enregistré.</td>
            </tr>
        @endforelse
    </table>
</body>
</html>
