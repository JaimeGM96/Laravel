<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use Illuminate\Http\Request;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ActivityController extends Controller
{
    public function index(){
        return ActivityResource::collection(Activity::all());
    }

    public function store(Request $request){
        $activity = Activity::create([
            'name' => $request->name,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);
        return new ActivityResource($activity);
    }
}
