<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function Players()
    {
        return $this->belongsToMany(Person::class, 'people_has_teams', 'person_id', 'team_id');
    }

    public function Videos()
    {
        return $this->hasMany(TeamsVideo::class, 'team_id', 'id');
    }

    public function Trainings()
    {
        return $this->hasMany(TrainingSchedule::class, 'team_id', 'id');
    }
}
