<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'last_name', 'biography', 'height', 'weight', 'phone', 'position', 'user_id'
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function Teams()
    {
        return $this->belongsToMany(Team::class, 'people_has_teams', 'team_id', 'person_id');
    }
}
