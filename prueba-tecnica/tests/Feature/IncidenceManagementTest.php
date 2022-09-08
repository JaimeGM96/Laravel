<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Incidence;
use App\Models\User;
use App\Models\Activity;

class IncidenceManagementTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_get_all_the_incidences(){
        $incidence = Incidence::factory()->create();
        
        $response = $this->get(route('incidences.index'));
        
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
    public function can_create_an_incidence(){
        $incidence = Incidence::factory()->make();

        $response = $this->post(route('incidences.store'), [
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

    /**
     * @test
     */
    // public function manager_users_of_an_activity_can_get_all_the_incidences_of_that_activity(){
    //     $activity = Activity::factory()->create();
    //     $user = User::factory()->hasAttached($activity, ['role_id' => UserRole::MANAGER])->create();
    //     $incidence = Incidence::factory()->create();
    //     $incidence->activity()->attach($activity);

    //     $data =[
    //         'user_id' => $user->id,
    //         'incidence_id' => $incidence->id,
    //         'activity_id' => $activity->id,
    //         'role_id' => UserRole::MANAGER,
    //     ];
        
    //     $response = $this->get(route('incidences.by.user', $user->id), $data);
        
    //     $response->assertOk();
        
    //     $response->assertJson([
    //         'data' => [
    //             [
    //                 'id' => $incidence->id,
    //                 'name' => $incidence->name,
    //                 'description' => $incidence->description,
    //             ]
    //         ]
    //     ]);
    // }
}
