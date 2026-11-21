<?php

namespace Tests\Feature;

use App\Models\Bien;
use App\Models\Categorie;
use App\Models\Maintenance;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MaintenanceTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_page_des_maintenances_s_affiche(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $this->get(route('maintenances.index'))
            ->assertOk();
    }

    public function test_on_peut_creer_une_maintenance(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

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

        protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
    }

    private function creerBien(): Bien
    {
        $categorie = Categorie::create([
            'nom' => 'Immobilier',
            'code' => 'IMMO-' . uniqid(),
            'description' => 'Biens immobiliers',
            'actif' => true,
        ]);

        return Bien::create([
            'categorie_id' => $categorie->id,
            'nom' => 'Immeuble administratif',
            'code' => 'B-' . uniqid(),
            'description' => 'Immeuble de bureaux',
            'valeur' => 250000000,
            'date_acquisition' => '2026-01-15',
            'etat' => 'bon',
            'localisation' => 'Libreville',
            'actif' => true,
        ]);
    }

    private function creerMaintenance(): Maintenance
    {
        return Maintenance::create([
            'bien_id' => $this->creerBien()->id,
            'type' => 'preventive',
            'date_maintenance' => '2026-02-01',
            'cout' => 150000,
            'description' => 'Entretien annuel',
            'prestataire' => 'TechnoServices',
            'statut' => 'terminee',
            'actif' => true,
        ]);
    }

    public function test_on_peut_voir_une_maintenance(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $maintenance = $this->creerMaintenance();

        $this->get(route('maintenances.show', $maintenance))
            ->assertOk()
            ->assertSee($maintenance->bien->nom)
            ->assertSee('Entretien annuel');
    }

    public function test_on_peut_modifier_une_maintenance(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $maintenance = $this->creerMaintenance();

        $this->put(route('maintenances.update', $maintenance), [
            'bien_id' => $maintenance->bien_id,
            'type' => 'corrective',
            'date_maintenance' => '2026-03-01',
            'cout' => 250000,
            'description' => 'Réparation climatisation',
            'prestataire' => 'Clim Services',
            'statut' => 'en_cours',
            'actif' => true,
        ])->assertRedirect(route('maintenances.index'));

        $this->assertDatabaseHas('maintenances', [
            'id' => $maintenance->id,
            'type' => 'corrective',
            'statut' => 'en_cours',
        ]);
    }

    public function test_on_peut_supprimer_une_maintenance(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $maintenance = $this->creerMaintenance();

        $this->delete(route('maintenances.destroy', $maintenance))
            ->assertRedirect(route('maintenances.index'));

        $this->assertDatabaseMissing('maintenances', [
            'id' => $maintenance->id,
        ]);
    }
}
