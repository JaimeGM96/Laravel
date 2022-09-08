<?php

namespace App\Http\Controllers;

use App\Http\Requests\ActivityRequest;
use App\Http\Requests\UserActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Http\Resources\IncidenceResource;
use App\Models\Activity;
use App\Models\Incidence;
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

    public function addUserToActivity(UserActivityRequest $request, ActivityServices $activityServices, Activity $activity){
        return new ActivityResource($activityServices->addUserToAnActivity($request->validated(), $activity));
    }

    public function getActivitiesByUser(User $user){
        return ActivityResource::collection($user->activities);
    }

    public function addIncidenceToActivity(Activity $activity, Incidence $incidence){
        $incidence->activity()->attach($activity);
        return new IncidenceResource($incidence);
    }
}
