<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectServices;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UserProjectRequest;
use App\Http\Resources\UserResource;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProjectResource::collection(Project::all());
    }

    public function store(ProjectRequest $request, ProjectServices $projectServices){
        return new ProjectResource($projectServices->createProject($request->validated()));
    }

    public function getUsers(Project $project){
        return UserResource::collection($project->users);
    }

    public function addUserToProject(UserProjectRequest $request, ProjectServices $projectServices, Project $project){
        return new ProjectResource($projectServices->addUserToProject($request->validated(), $project));
    }
}
