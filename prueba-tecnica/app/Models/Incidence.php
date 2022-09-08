<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidence extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
    ];

    public function activity(){
        return $this->belongsToMany(Activity::class, 'incidence_activity');
    }
    
    public function users(){
        return $this->belongsToMany(User::class, 'user_incidences');
    }
}
