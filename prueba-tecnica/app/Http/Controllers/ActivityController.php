<?php

namespace App\Http\Controllers;

use App\Http\Resources\ActivityResource;
use Illuminate\Http\Request;
use App\Models\Activity;

class ActivityController extends Controller
{
    public function index(){
        return ActivityResource::collection(Activity::all());
    }
}
