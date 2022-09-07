<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserRole;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function users(){
        return $this->belongsToMany(User::class, 'user_activities')->withPivot('role_id');
    }

    public function project(){
        return $this->belongsToMany(Project::class);
    }
    
    public function incidences(){
        return $this->hasMany(Incidence::class);
    }

    public function isManager(User $user){
        return $user->activities()->where('role_id', UserRole::MANAGER)->exists();
    }

    // public function canBeAssigned(User $user){
    //     return !project()->isManager($user);
    // }
}
