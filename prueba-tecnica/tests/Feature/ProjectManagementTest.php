<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Project;
use App\Models\User;
use App\Enums\UserRole;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_create_a_project(){
        $project = Project::factory()->make();

        $response = $this->post('/projects', [
            'name' => $project->name,
            'description' => $project->description,
        ]);

        $response->assertCreated();

        $response->assertJson([
            'data' => [
                'name' => $project->name,
                'description' => $project->description,
            ]
        ]);

        $this->assertDatabaseHas('projects', [
            'name' => $project->name,
            'description' => $project->description,
        ]);
    }

    /**
     * @test
     */
    public function an_user_can_be_added_to_a_project_as_participant(){
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $response = $this->post('/projects/'.$project->id.'/users', [
            'user_id' => $user->id,
            'role_id' => UserRole::PARTICIPANT->value,
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('user_projects', [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role_id' => UserRole::PARTICIPANT->value,
        ]);
    }

    /**
     * @test
     */
    public function an_user_can_be_added_to_a_project_as_manager(){
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $response = $this->post('/projects/'.$project->id.'/users', [
            'user_id' => $user->id,
            'role_id' => UserRole::MANAGER->value,
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('user_projects', [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role_id' => UserRole::MANAGER->value,
        ]);
    }

    /**
     * @test
     */
    public function an_user_can_be_added_to_a_project_as_participant_and_manager(){
        $project = Project::factory()->create();
        $user = User::factory()->create();

        $response = $this->post('/projects/'.$project->id.'/users', [
            'user_id' => $user->id,
            'role_id' => UserRole::BOTH->value,
        ]);

        $response->assertCreated();

        $this->assertDatabaseHas('user_projects', [
            'user_id' => $user->id,
            'project_id' => $project->id,
            'role_id' => UserRole::BOTH->value,
        ]);
    }

    /**
     * @test
     */
    public function can_get_all_participants_by_project(){
        $project = Project::factory()->create();
        $user = User::factory()->hasAttached($project, ['role_id' => UserRole::PARTICIPANT])->create();

        $response = $this->get(route('projects.users', $project->id));
        
        $response->assertOk();

        $response->assertJson([
            'data' => [
                [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                ]
            ]
        ]);
    }
}
