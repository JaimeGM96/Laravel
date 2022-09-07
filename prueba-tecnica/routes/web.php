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
    Route::post('/', 'store')->name('projects.store');
    Route::get('/{project}/users', 'getUsers')->name('projects.users');
    Route::post('/{project}/users', 'addUserToProject')->name('add.user.project');
});

Route::controller(ActivityController::class)->prefix('activities')->group(function(){
    Route::get('/', 'index')->name('activities.index');
    Route::post('/', 'store')->name('activities.store');
    Route::post('/{activity}/users', 'addUserToActivity')->name('add.user.to.activity');
});

Route::controller(IncidenceController::class)->prefix('incidences')->group(function(){
    Route::get('/', 'index')->name('incidences.index');
    Route::post('/', 'store')->name('incidences.store');
});

Route::controller(ActivityController::class)->prefix('users')->group(function(){
    Route::get('/{user}/activities', 'getActivitiesByUser')->name('users.activities');
    Route::post('/', 'store');
});
