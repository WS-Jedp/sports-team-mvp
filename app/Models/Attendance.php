<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function Schedule()
    {
        return $this->belongsTo(TrainingSchedule::class, 'schedule_id', 'id');
    }
}
