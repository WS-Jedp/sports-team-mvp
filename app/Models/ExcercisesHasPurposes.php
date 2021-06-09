<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcercisesHasPurposes extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['exercise_id', 'purpose_id'];
}
