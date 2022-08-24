<?php

namespace Tests\Feature;

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
    public function a_project_can_be_created(){
        $project = Project::factory()->create();

        $response = $this->get('/projects');
        
        $response->assertSee($project->name);

        //$response->assertOk();
    }
}
