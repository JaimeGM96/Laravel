<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidence;
use App\Http\Resources\IncidenceResource;
use Illuminate\Support\Facades\Auth;

class IncidenceController extends Controller
{
    public function index(){
        return IncidenceResource::collection(Incidence::all());
    }

    public function store(Request $request){
        $incidence = Incidence::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);
        return new IncidenceResource($incidence);
    }
}
