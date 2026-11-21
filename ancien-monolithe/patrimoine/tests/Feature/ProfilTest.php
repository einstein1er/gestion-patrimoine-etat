<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProfilTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(PreventRequestForgery::class);
    }

    private function creerUtilisateur(): Utilisateur
    {
        return Utilisateur::create([
            'nom' => 'Utilisateur Test',
            'email' => 'profil' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]);
    }

    public function test_la_page_du_profil_s_affiche(): void
    {
        $utilisateur = $this->creerUtilisateur();

        $this->actingAs($utilisateur)
            ->get(route('profil.edit'))
            ->assertOk();
    }

    public function test_on_peut_modifier_ses_informations(): void
    {
        $utilisateur = $this->creerUtilisateur();

        $this->actingAs($utilisateur)
            ->put(route('profil.informations'), [
                'nom' => 'Nouveau Nom',
                'email' => 'nouveau' . uniqid() . '@patrimoine.ga',
            ])
            ->assertRedirect(route('profil.edit'));

        $this->assertDatabaseHas('utilisateurs', [
            'id' => $utilisateur->id,
            'nom' => 'Nouveau Nom',
        ]);
    }

    public function test_on_peut_modifier_son_mot_de_passe(): void
    {
        $utilisateur = $this->creerUtilisateur();

        $this->actingAs($utilisateur)
            ->put(route('profil.mot-de-passe'), [
                'mot_de_passe_actuel' => 'motdepasse123',
                'mot_de_passe' => 'nouveaumotdepasse123',
                'mot_de_passe_confirmation' => 'nouveaumotdepasse123',
            ])
            ->assertRedirect(route('profil.edit'));

        $this->assertTrue(Hash::check('nouveaumotdepasse123', $utilisateur->fresh()->mot_de_passe));
    }

    public function test_on_ne_peut_pas_modifier_avec_un_mauvais_mot_de_passe_actuel(): void
    {
        $utilisateur = $this->creerUtilisateur();

        $this->actingAs($utilisateur)
            ->put(route('profil.mot-de-passe'), [
                'mot_de_passe_actuel' => 'mauvais_mot_de_passe',
                'mot_de_passe' => 'nouveaumotdepasse123',
                'mot_de_passe_confirmation' => 'nouveaumotdepasse123',
            ])
            ->assertSessionHasErrors('mot_de_passe_actuel');
    }
}
