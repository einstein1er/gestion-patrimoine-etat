<?php

namespace Tests\Feature;

use App\Models\Bien;
use App\Models\Categorie;
use App\Models\Maintenance;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_page_des_maintenances_s_affiche(): void
    {
        $this->get(route('maintenances.index'))
            ->assertOk();
    }

    public function test_on_peut_creer_une_maintenance(): void
    {
        $this->withSession(['_token' => 'jeton-de-test']);

        $categorie = Categorie::create([
            'nom' => 'Immobilier',
            'code' => 'IMMO',
            'description' => 'Biens immobiliers',
            'actif' => true,
        ]);

        $bien = Bien::create([
            'categorie_id' => $categorie->id,
            'nom' => 'Immeuble administratif',
            'code' => 'B-001',
            'description' => 'Immeuble de bureaux',
            'valeur' => 250000000,
            'date_acquisition' => '2026-01-15',
            'etat' => 'bon',
            'localisation' => 'Libreville',
            'actif' => true,
        ]);

        $reponse = $this->post(route('maintenances.store'), [
            '_token' => 'jeton-de-test',
            'bien_id' => $bien->id,
            'type' => 'preventive',
            'date_maintenance' => '2026-02-01',
            'cout' => 150000,
            'description' => 'Entretien annuel',
            'prestataire' => 'TechnoServices',
            'statut' => 'terminee',
            'actif' => true,
        ]);

        $reponse->assertRedirect(route('maintenances.index'));

        $this->assertDatabaseHas('maintenances', [
            'bien_id' => $bien->id,
            'type' => 'preventive',
            'statut' => 'terminee',
        ]);
    }
}
