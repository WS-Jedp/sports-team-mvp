<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Excercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'cover_url', 'video_url', 'type_id', 'purposes'
    ];

    public function Type()
    {
        return $this->belongsTo(ExcerciseType::class, 'type_id', 'id');
    }

    public function Purposes()
    {
        return $this->belongsToMany(ExcercisePurpose::class, 'excercises_has_purposes', 'purpose_id', 'excercise_id');
    }

    public function TrainingSchedules()
    {
        return $this->belongsToMany(TrainingSchedule::class, 'trainings_has_excercises', 'schedule_id', 'excercise_id');
    }
}
