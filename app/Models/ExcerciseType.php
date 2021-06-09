<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcerciseType extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function Excercises()
    {
        return $this->hasMany(Excercise::class, 'type_id', 'id');
    }
}
