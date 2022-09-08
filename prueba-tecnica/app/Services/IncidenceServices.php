<?php

namespace App\Services;

use App\Models\Incidence;
use App\Enums\UserRole;
use App\Models\User;

class IncidenceServices
{
    public function createIncidence($request): Incidence
    {
        $incidence = new Incidence($request);
        $incidence->save();
        return $incidence;
    }

    public function getIncidencesByUser($request)
    {
        $user = User::findOrFail($request['user_id']);
        $incidences = $user->incidences;
        return $incidences;
    }
}