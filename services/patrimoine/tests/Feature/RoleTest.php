<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    private function creerUtilisateur(string $role): Utilisateur
    {
        return Utilisateur::create([
            'nom' => 'Utilisateur ' . $role,
            'email' => $role . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => $role,
            'actif' => true,
        ]);
    }

    public function test_un_administrateur_peut_acceder_aux_utilisateurs(): void
    {
        $utilisateur = $this->creerUtilisateur('administrateur');

        $this->actingAs($utilisateur)
            ->get(route('utilisateurs.index'))
            ->assertOk();
    }

    public function test_un_gestionnaire_ne_peut_pas_acceder_aux_utilisateurs(): void
    {
        $utilisateur = $this->creerUtilisateur('gestionnaire');

        $this->actingAs($utilisateur)
            ->get(route('utilisateurs.index'))
            ->assertForbidden();
    }

    public function test_un_consultant_peut_acceder_aux_rapports(): void
    {
        $utilisateur = $this->creerUtilisateur('consultant');

        $this->actingAs($utilisateur)
            ->get(route('rapports.index'))
            ->assertOk();
    }

    public function test_un_consultant_ne_peut_pas_creer_un_bien(): void
    {
        $utilisateur = $this->creerUtilisateur('consultant');

        $this->actingAs($utilisateur)
            ->get(route('biens.create'))
            ->assertForbidden();
    }
}
