<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Activity;

class ActivityManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_all_the_activities(){
        $activity = Activity::factory()->create();

        $response = $this->get('/activities');

        $response->assertOk();
        
        $response->assertJson([
            'data' => [
                [
                    'id' => $activity->id,
                    'name' => $activity->name,
                    'description' => $activity->description,
                ]
            ]
        ]);
    }

    /**
     * @test
     */
    public function can_create_a_activity(){
        $activity = Activity::factory()->make();

        $response = $this->post('/activities', [
            'name' => $activity->name,
            'description' => $activity->description,
        ]);

        $response->assertCreated();
        
        $response->assertJson([
            'data' => [
                'name' => $activity->name,
                'description' => $activity->description,
            ]
        ]);
        
        $this->assertDatabaseHas('activities', [
            'name' => $activity->name,
            'description' => $activity->description,
        ]);
    }
}
