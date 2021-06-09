<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcercisePurpose extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function Excercises()
    {
        return $this->belongsToMany(Excercise::class, 'excercises_has_purposes', 'excercise_id', 'purpose_id');
    }
}
