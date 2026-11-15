<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RapportTest extends TestCase
{
    use RefreshDatabase;

    public function test_la_page_des_rapports_s_affiche(): void
    {
        $this->get(route('rapports.index'))
            ->assertOk()
            ->assertSee('Rapports du patrimoine');
    }
}
