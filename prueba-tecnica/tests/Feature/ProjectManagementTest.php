<?php

namespace Tests\Feature;

use App\Http\Resources\ProjectResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Project;

class ProjectManagementTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function can_get_all_the_projects(){
        $project = Project::factory()->create();

        $response = $this->get('/projects');
        
        $response->assertOk();

        $response->assertJson([
            'data' => [
                [
                    'id' => $project->id,
                    'name' => $project->name,
                    'description' => $project->description,
                ]
            ]
        ]);
    }

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
}
