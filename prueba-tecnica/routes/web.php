<?php

use App\Http\Controllers\ActivityController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\IncidenceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::controller(ProjectController::class)->prefix('projects')->group(function(){
    Route::get('/', 'index')->middleware('can:viewAny,App\Models\Project')->name('projects.index');
    Route::post('/', 'store');
    Route::get('/{project}/users', 'getUsers')->name('projects.users');
});

Route::controller(ActivityController::class)->prefix('activities')->group(function(){
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::post('/{activity}/users', ['as' => 'add.user.activity', 'uses' => 'addUserToActivity']);
});

Route::controller(IncidenceController::class)->prefix('incidences')->group(function(){
    Route::get('/', 'index');
    Route::post('/', 'store');
});

Route::controller(ActivityController::class)->prefix('users')->group(function(){
    Route::get('/{user}/activities', 'getActivitiesByUser');
    Route::post('/', 'store');
});
