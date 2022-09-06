<?php

namespace App\Services;

use App\Models\Activity;
use App\Enums\UserRole;

class ActivityServices
{
    public function createActivity($request): Activity
    {
        $activity = new Activity($request);
        $activity->save();
        return $activity;
    }

    public function addUserToAnActivity($request)
    {
        //
    }

}