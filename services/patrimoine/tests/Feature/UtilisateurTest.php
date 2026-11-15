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
        $this->get(route('utilisateurs.index'))
            ->assertOk();
    }

    public function test_on_peut_creer_un_utilisateur(): void
    {
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
}
