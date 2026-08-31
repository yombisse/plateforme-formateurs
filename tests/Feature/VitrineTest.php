<?php

namespace Tests\Feature;

use Tests\TestCase;

class VitrineTest extends TestCase
{
    public function test_homepage_displays_formateur_profile_from_controller(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('Aïcha Diallo');
        $response->assertSee('Marketing Digital');
        $response->assertSee('Formations disponibles');
        $response->assertSee("S'inscrire");
    }
}
