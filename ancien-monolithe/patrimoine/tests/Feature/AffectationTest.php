<?php

namespace Tests\Feature;

use App\Models\Affectation;
use App\Models\Bien;
use App\Models\Categorie;
use App\Models\Localisation;
use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;

class AffectationTest extends TestCase
{
    use RefreshDatabase;
        protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(PreventRequestForgery::class);
    }

    public function test_la_page_des_affectations_s_affiche(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $this->get(route('affectations.index'))
            ->assertOk();
    }

    public function test_on_peut_creer_une_affectation(): void
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

        $localisation = Localisation::create([
            'nom' => 'Estuaire',
            'code' => 'EST',
            'type' => 'province',
            'actif' => true,
        ]);

        $reponse = $this->post(route('affectations.store'), [
            '_token' => 'jeton-de-test',
            'bien_id' => $bien->id,
            'localisation_id' => $localisation->id,
            'date_debut' => '2026-01-20',
            'date_fin' => null,
            'responsable' => 'Direction générale',
            'observation' => 'Affectation initiale',
            'actif' => true,
        ]);

        $reponse->assertRedirect(route('affectations.index'));

        $this->assertDatabaseHas('affectations', [
            'bien_id' => $bien->id,
            'localisation_id' => $localisation->id,
            'responsable' => 'Direction générale',
        ]);
    }

        private function creerAffectation(): Affectation
    {
        $categorie = Categorie::create([
            'nom' => 'Immobilier',
            'code' => 'IMMO',
            'description' => 'Biens immobiliers',
            'actif' => true,
        ]);

        $bien = Bien::create([
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

        $localisation = Localisation::create([
            'nom' => 'Estuaire',
            'code' => 'EST-' . uniqid(),
            'type' => 'province',
            'actif' => true,
        ]);

        return Affectation::create([
            'bien_id' => $bien->id,
            'localisation_id' => $localisation->id,
            'date_debut' => '2026-01-20',
            'date_fin' => null,
            'responsable' => 'Direction générale',
            'observation' => 'Affectation initiale',
            'actif' => true,
        ]);
    }

    public function test_on_peut_voir_une_affectation(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $affectation = $this->creerAffectation();

        $this->get(route('affectations.show', $affectation))
            ->assertOk()
            ->assertSee($affectation->bien->nom)
            ->assertSee($affectation->localisation->nom);
    }

    public function test_on_peut_modifier_une_affectation(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $affectation = $this->creerAffectation();

        $this->put(route('affectations.update', $affectation), [
            'bien_id' => $affectation->bien_id,
            'localisation_id' => $affectation->localisation_id,
            'date_debut' => '2026-02-01',
            'date_fin' => '2026-12-31',
            'responsable' => 'Direction financière',
            'observation' => 'Affectation modifiée',
            'actif' => true,
        ])->assertRedirect(route('affectations.index'));

        $this->assertDatabaseHas('affectations', [
            'id' => $affectation->id,
            'responsable' => 'Direction financière',
            'observation' => 'Affectation modifiée',
        ]);
    }

    public function test_on_peut_supprimer_une_affectation(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $affectation = $this->creerAffectation();

        $this->delete(route('affectations.destroy', $affectation))
            ->assertRedirect(route('affectations.index'));

        $this->assertDatabaseMissing('affectations', [
            'id' => $affectation->id,
        ]);
    }
}
