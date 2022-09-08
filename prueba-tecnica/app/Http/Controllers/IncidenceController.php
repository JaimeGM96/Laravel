<?php

namespace App\Http\Controllers;

use App\Models\Incidence;
use App\Http\Resources\IncidenceResource;
use App\Http\Requests\IncidenceRequest;
use App\Http\Requests\UserIncidenceRequest;
use App\Models\User;
use App\Services\IncidenceServices;

class IncidenceController extends Controller
{
    public function index(){
        return IncidenceResource::collection(Incidence::all());
    }

    public function store(IncidenceRequest $request, IncidenceServices $incidenceServices){
        return new IncidenceResource($incidenceServices->createIncidence($request->validated()));
    }

    public function getIncidencesByUser(UserIncidenceRequest $request, IncidenceServices $incidenceServices){
        return IncidenceResource::collection($incidenceServices->getIncidencesByUser($request->validated()));
    }
}
