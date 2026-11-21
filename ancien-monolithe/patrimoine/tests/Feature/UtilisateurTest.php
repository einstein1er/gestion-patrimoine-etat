<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UtilisateurTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_page_des_utilisateurs_s_affiche(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $this->get(route('utilisateurs.index'))
            ->assertOk();
    }

    public function test_on_peut_creer_un_utilisateur(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $this->withSession(['_token' => 'jeton-de-test']);

        $reponse = $this->post(route('utilisateurs.store'), [
            '_token' => 'jeton-de-test',
            'nom' => 'Admin Patrimoine',
            'email' => 'admin@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'mot_de_passe_confirmation' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]);

        $reponse->assertRedirect(route('utilisateurs.index'));

        $this->assertDatabaseHas('utilisateurs', [
            'nom' => 'Admin Patrimoine',
            'email' => 'admin@patrimoine.ga',
            'role' => 'administrateur',
        ]);
    }

        protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware(\Illuminate\Foundation\Http\Middleware\PreventRequestForgery::class);
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

    public function test_on_peut_voir_un_utilisateur(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $utilisateur = $this->creerAdministrateur();

        $this->get(route('utilisateurs.show', $utilisateur))
            ->assertOk()
            ->assertSee($utilisateur->nom)
            ->assertSee($utilisateur->email);
    }

    public function test_on_peut_modifier_un_utilisateur(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $utilisateur = $this->creerAdministrateur();

        $this->put(route('utilisateurs.update', $utilisateur), [
            'nom' => 'Nom modifié',
            'email' => 'modifie' . uniqid() . '@patrimoine.ga',
            'role' => 'gestionnaire',
            'actif' => true,
        ])->assertRedirect(route('utilisateurs.index'));

        $this->assertDatabaseHas('utilisateurs', [
            'id' => $utilisateur->id,
            'nom' => 'Nom modifié',
            'role' => 'gestionnaire',
        ]);
    }

    public function test_on_peut_supprimer_un_utilisateur(): void
    {
        $this->actingAs($this->creerAdministrateur());

        $utilisateur = $this->creerAdministrateur();

        $this->delete(route('utilisateurs.destroy', $utilisateur))
            ->assertRedirect(route('utilisateurs.index'));

        $this->assertDatabaseMissing('utilisateurs', [
            'id' => $utilisateur->id,
        ]);
    }

    public function test_un_consultant_ne_peut_pas_acceder_aux_utilisateurs(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Consultant Test',
            'email' => 'consultant' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'consultant',
            'actif' => true,
        ]));

        $this->get(route('utilisateurs.index'))
            ->assertForbidden();
    }
}
