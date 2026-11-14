<?php

namespace Tests\Feature;

use App\Models\Bien;
use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BienTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_page_des_biens_s_affiche(): void
    {
        $this->get(route('biens.index'))
            ->assertOk();
    }

    public function test_on_peut_creer_un_bien(): void
    {
        $this->withSession(['_token' => 'jeton-de-test']);

        $categorie = Categorie::create([
            'nom' => 'Immobilier',
            'code' => 'IMMO',
            'description' => 'Biens immobiliers',
            'actif' => true,
        ]);

        $reponse = $this->post(route('biens.store'), [
            '_token' => 'jeton-de-test',
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

        $reponse->assertRedirect(route('biens.index'));

        $this->assertDatabaseHas('biens', [
            'nom' => 'Immeuble administratif',
            'code' => 'B-001',
        ]);
    }
}
