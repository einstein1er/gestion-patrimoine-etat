<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthentificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_page_de_connexion_s_affiche(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Connexion');
    }

    public function test_on_peut_se_connecter_avec_des_identifiants_valides(): void
    {
        $this->withSession(['_token' => 'jeton-de-test']);

        $utilisateur = Utilisateur::create([
            'nom' => 'Admin Patrimoine',
            'email' => 'admin@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]);

        $reponse = $this->post(route('login.store'), [
            '_token' => 'jeton-de-test',
            'email' => 'admin@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
        ]);

        $reponse->assertRedirect(route('rapports.index'));
        $this->assertAuthenticatedAs($utilisateur);
    }

    public function test_les_pages_sont_protegees_par_connexion(): void
    {
        $this->get(route('biens.index'))
            ->assertRedirect(route('login'));
    }
}
