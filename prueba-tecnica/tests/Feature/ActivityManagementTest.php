<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Activity;
use App\Models\User;
use App\Enums\UserRole;

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
    public function can_create_an_activity(){
        $activity = Activity::factory()->make();
        $user = User::factory()->create();

        $this->actingAs($user);

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

    /**
     * @test
     */
    public function can_add_an_user_to_an_activity_as_participant(){
        $activity = Activity::factory()->create();
        $user = User::factory()->create();

        $response = $this->post('/activities/'.$activity->id.'/users', [
            'user_id' => $user->id,
            'role_id' => UserRole::PARTICIPANT->value,
        ]);

        $response->assertCreated();
        
        $this->assertDatabaseHas('user_activities', [
            'user_id' => $user->id,
            'activity_id' => $activity->id,
        ]);
    }

    /**
     * @test
     */
    public function can_add_an_user_to_an_activity_as_manager(){
        $activity = Activity::factory()->create();
        $user = User::factory()->create();

        $response = $this->post('/activities/'.$activity->id.'/users', [
            'user_id' => $user->id,
            'role_id' => UserRole::MANAGER->value,
        ]);

        $response->assertCreated();
        
        $this->assertDatabaseHas('user_activities', [
            'user_id' => $user->id,
            'activity_id' => $activity->id,
        ]);
    }

    /**
     * @test
     */
    public function can_list_all_activities_of_an_user(){
        $activity = Activity::factory()->create();
        $user = User::factory()->hasAttached($activity, ['role_id' => UserRole::PARTICIPANT])->create();

        $response = $this->get(route('users.activities', $user->id));

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
}
