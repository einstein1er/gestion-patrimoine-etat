<?php

namespace Tests\Feature;

use App\Models\Localisation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalisationTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_page_des_localisations_s_affiche(): void
    {
        $this->get(route('localisations.index'))
            ->assertOk();
    }

    public function test_on_peut_creer_une_localisation(): void
    {
        $this->withSession(['_token' => 'jeton-de-test']);

        $reponse = $this->post(route('localisations.store'), [
            '_token' => 'jeton-de-test',
            'nom' => 'Estuaire',
            'code' => 'EST',
            'type' => 'province',
            'parent_id' => null,
            'actif' => true,
        ]);

        $reponse->assertRedirect(route('localisations.index'));

        $this->assertDatabaseHas('localisations', [
            'nom' => 'Estuaire',
            'code' => 'EST',
        ]);
    }
}
