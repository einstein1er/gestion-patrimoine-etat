<?php

namespace Tests\Feature;

use App\Models\Bien;
use App\Models\Categorie;
use App\Models\Utilisateur;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BienTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(PreventRequestForgery::class);
    }

    private function creerAdministrateur(): Utilisateur
    {
        return Utilisateur::create([
            'nom' => 'Administrateur Test',
            'email' => 'admin' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]);
    }

    private function creerCategorie(): Categorie
    {
        return Categorie::create([
            'nom' => 'Immobilier',
            'code' => 'IMMO-' . uniqid(),
            'description' => 'Biens immobiliers',
            'actif' => true,
        ]);
    }

    private function creerBien(): Bien
    {
        return Bien::create([
            'categorie_id' => $this->creerCategorie()->id,
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

    public function test_la_page_des_biens_s_affiche(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $this->get(route('biens.index'))
            ->assertOk();
    }

    public function test_on_peut_creer_un_bien(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $categorie = $this->creerCategorie();

        $this->post(route('biens.store'), [
            'categorie_id' => $categorie->id,
            'nom' => 'Immeuble administratif',
            'code' => 'B-' . uniqid(),
            'description' => 'Immeuble de bureaux',
            'valeur' => 250000000,
            'date_acquisition' => '2026-01-15',
            'etat' => 'bon',
            'localisation' => 'Libreville',
            'actif' => true,
        ])->assertRedirect(route('biens.index'));

        $this->assertDatabaseHas('biens', [
            'nom' => 'Immeuble administratif',
            'categorie_id' => $categorie->id,
        ]);
    }

    public function test_on_peut_voir_un_bien(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $bien = $this->creerBien();

        $this->get(route('biens.show', $bien))
            ->assertOk()
            ->assertSee($bien->nom);
    }

    public function test_on_peut_modifier_un_bien(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $bien = $this->creerBien();

        $this->put(route('biens.update', $bien), [
            'categorie_id' => $bien->categorie_id,
            'nom' => 'Immeuble modifié',
            'code' => $bien->code,
            'description' => 'Description modifiée',
            'valeur' => 300000000,
            'date_acquisition' => '2026-01-15',
            'etat' => 'bon',
            'localisation' => 'Libreville',
            'actif' => true,
        ])->assertRedirect(route('biens.index'));

        $this->assertDatabaseHas('biens', [
            'id' => $bien->id,
            'nom' => 'Immeuble modifié',
        ]);
    }

    public function test_on_peut_supprimer_un_bien(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $bien = $this->creerBien();

        $this->delete(route('biens.destroy', $bien))
            ->assertRedirect(route('biens.index'));

        $this->assertDatabaseMissing('biens', [
            'id' => $bien->id,
        ]);
    }

    public function test_on_ne_peut_pas_creer_un_bien_sans_nom(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $categorie = $this->creerCategorie();

        $this->post(route('biens.store'), [
            'categorie_id' => $categorie->id,
            'code' => 'B-' . uniqid(),
            'valeur' => 100000,
            'etat' => 'bon',
        ])->assertSessionHasErrors('nom');
    }
}