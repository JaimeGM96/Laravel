<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Http\Requests\UserActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Services\ActivityServices;
use App\Models\User;

class ActivityController extends Controller
{
    public function index(){
        return ActivityResource::collection(Activity::all());
    }

    public function store(ActivityRequest $request, ActivityServices $activityServices){
        return new ActivityResource($activityServices->createActivity($request->validated()));
    }

    public function addUserToActivity(UserActivityRequest $request, ActivityServices $activityServices){
        return new ActivityResource($activityServices->addUserToAnActivity($request->validated()));
    }

    public function getActivitiesByUser(User $user){
        return ActivityResource::collection($user->activities);
    }
}
