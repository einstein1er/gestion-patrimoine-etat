<?php

namespace Tests\Feature;

use App\Models\Categorie;
use App\Models\Utilisateur;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategorieTest extends TestCase
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

    public function test_la_page_des_categories_s_affiche(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $this->get(route('categories.index'))
            ->assertOk();
    }

    public function test_on_peut_creer_une_categorie(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $this->post(route('categories.store'), [
            'nom' => 'Véhicules',
            'code' => 'VEH-' . uniqid(),
            'description' => 'Véhicules administratifs',
            'actif' => true,
        ])->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'nom' => 'Véhicules',
        ]);
    }

    public function test_on_peut_voir_une_categorie(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $categorie = $this->creerCategorie();

        $this->get(route('categories.show', $categorie))
            ->assertOk()
            ->assertSee($categorie->nom);
    }

    public function test_on_peut_modifier_une_categorie(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $categorie = $this->creerCategorie();

        $this->put(route('categories.update', $categorie), [
            'nom' => 'Immobilier modifié',
            'code' => $categorie->code,
            'description' => 'Description modifiée',
            'actif' => true,
        ])->assertRedirect(route('categories.index'));

        $this->assertDatabaseHas('categories', [
            'id' => $categorie->id,
            'nom' => 'Immobilier modifié',
        ]);
    }

    public function test_on_peut_supprimer_une_categorie(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $categorie = $this->creerCategorie();

        $this->delete(route('categories.destroy', $categorie))
            ->assertRedirect(route('categories.index'));

        $this->assertDatabaseMissing('categories', [
            'id' => $categorie->id,
        ]);
    }

    public function test_on_ne_peut_pas_creer_une_categorie_sans_nom(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $this->post(route('categories.store'), [
            'code' => 'CODE-' . uniqid(),
            'actif' => true,
        ])->assertSessionHasErrors('nom');
    }
}