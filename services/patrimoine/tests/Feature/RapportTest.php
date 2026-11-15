<?php

namespace Tests\Feature;

use App\Models\Utilisateur;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RapportTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_page_des_rapports_s_affiche(): void
    {
        $this->actingAs(Utilisateur::create([
            'nom' => 'Test Patrimoine',
            'email' => 'test' . uniqid() . '@patrimoine.ga',
            'mot_de_passe' => 'motdepasse123',
            'role' => 'administrateur',
            'actif' => true,
        ]));

        $this->get(route('rapports.index'))
            ->assertOk()
            ->assertSee('Rapports du patrimoine');
    }
}
