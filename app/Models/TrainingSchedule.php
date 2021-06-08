<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSchedule extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function Attendances()
    {
        return $this->hasMany(Attendance::class, 'schedule_id', 'id');
    }

    public function Team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }

    public function Excercises()
    {
        return $this->belongsToMany(Excercise::class, 'trainings_has_excercises', 'excercise_id', 'schedule_id');
    }
}
