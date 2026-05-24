<?php

namespace Tests\Feature;

use Tests\TestCase;

class PagesTest extends TestCase
{
    public function test_home_page_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Coisas de Núbia');
    }

    public function test_croche_page_loads(): void
    {
        $response = $this->get('/croche');
        $response->assertStatus(200);
        $response->assertSee('Crochê');
    }

    public function test_bordados_page_loads(): void
    {
        $response = $this->get('/bordados');
        $response->assertStatus(200);
        $response->assertSee('Bordados');
    }

    public function test_doces_page_loads(): void
    {
        $response = $this->get('/doces');
        $response->assertStatus(200);
        $response->assertSee('Doces');
    }
}
