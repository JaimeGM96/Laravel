<?php

namespace App\Services;

use App\Models\Project;
use App\Enums\UserRole;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Database\Console\DumpCommand;

class ProjectServices
{
    public function createProject($request): Project
    {
        $project = new Project($request);
        $project->save();
        return $project;
    }

    public function addUserToProject($request, Project $project): Project
    {
        $project->users()->attach($request['user_id'], ['role_id' => $request['role_id']]);
        return $project;
    }
}