<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Incidence;

class IncidenceManagementTest extends TestCase
{
    /**
     * @test
     */
    public function can_get_all_the_incidences(){
        $incidence = Incidence::factory()->create();
        
        $response = $this->get('/incidences');
        
        $response->assertOk();
        
        $response->assertJson([
            'data' => [
                [
                    'id' => $incidence->id,
                    'name' => $incidence->name,
                    'description' => $incidence->description,
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function can_create_a_incidence(){
        $incidence = Incidence::factory()->make();
        
        $response = $this->post('/incidences', [
            'name' => $incidence->name,
            'description' => $incidence->description,
        ]);
        
        $response->assertCreated();
        
        $response->assertJson([
            'data' => [
                'name' => $incidence->name,
                'description' => $incidence->description,
            ]
        ]);
        
        $this->assertDatabaseHas('incidences', [
            'name' => $incidence->name,
            'description' => $incidence->description,
        ]);
    }
}
