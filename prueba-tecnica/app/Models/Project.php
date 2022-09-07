<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\UserRole;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function activities(){
        return $this->belongsToMany(Activity::class);
    }

    public function users(){
        return $this->belongsToMany(User::class, 'user_projects')->withPivot('role_id');
    }

    public function isManager(User $user){
        return $user->projects()->where('role_id', [UserRole::MANAGER, UserRole::BOTH])->exists();
    }

    public function isParticipant(User $user){
        return $user->projects()->where('role_id', [UserRole::PARTICIPANT, UserRole::BOTH])->exists();
    }
}
