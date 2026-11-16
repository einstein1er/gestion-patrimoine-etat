<?php

namespace Tests\Feature;

use App\Models\Localisation;
use App\Models\Utilisateur;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalisationTest extends TestCase
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

    private function creerLocalisation(): Localisation
    {
        return Localisation::create([
            'nom' => 'Estuaire',
            'code' => 'EST-' . uniqid(),
            'type' => 'province',
            'parent_id' => null,
            'actif' => true,
        ]);
    }

    public function test_la_page_des_localisations_s_affiche(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $this->get(route('localisations.index'))
            ->assertOk();
    }

    public function test_on_peut_creer_une_localisation(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $this->post(route('localisations.store'), [
            'nom' => 'Libreville',
            'code' => 'LBV-' . uniqid(),
            'type' => 'commune',
            'parent_id' => null,
            'actif' => true,
        ])->assertRedirect(route('localisations.index'));

        $this->assertDatabaseHas('localisations', [
            'nom' => 'Libreville',
        ]);
    }

    public function test_on_peut_voir_une_localisation(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $localisation = $this->creerLocalisation();

        $this->get(route('localisations.show', $localisation))
            ->assertOk()
            ->assertSee($localisation->nom);
    }

    public function test_on_peut_modifier_une_localisation(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $localisation = $this->creerLocalisation();

        $this->put(route('localisations.update', $localisation), [
            'nom' => 'Estuaire modifié',
            'code' => $localisation->code,
            'type' => 'province',
            'parent_id' => null,
            'actif' => true,
        ])->assertRedirect(route('localisations.index'));

        $this->assertDatabaseHas('localisations', [
            'id' => $localisation->id,
            'nom' => 'Estuaire modifié',
        ]);
    }

    public function test_on_peut_supprimer_une_localisation(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $localisation = $this->creerLocalisation();

        $this->delete(route('localisations.destroy', $localisation))
            ->assertRedirect(route('localisations.index'));

        $this->assertDatabaseMissing('localisations', [
            'id' => $localisation->id,
        ]);
    }

    public function test_on_ne_peut_pas_creer_une_localisation_sans_nom(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $this->post(route('localisations.store'), [
            'code' => 'CODE-' . uniqid(),
            'type' => 'commune',
        ])->assertSessionHasErrors('nom');
    }
}