<?php

namespace App\Services;

use App\Models\Incidence;
use App\Enums\UserRole;
use Illuminate\Database\Console\DumpCommand;

class IncidenceServices
{
    public function createIncidence($request): Incidence
    {
        $incidence = new Incidence($request);
        $incidence->save();
        return $incidence;
    }
}