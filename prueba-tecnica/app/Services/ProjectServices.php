<?php

namespace App\Services;

use App\Models\Project;
use App\Enums\UserRole;
use Illuminate\Database\Console\DumpCommand;

class ProjectServices
{
    public function createProject($request): Project
    {
        $project = new Project($request);
        $project->save();
        return $project;
    }
}