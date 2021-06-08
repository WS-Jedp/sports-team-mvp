<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamsVideo extends Model
{
    use HasFactory;

    public function Team()
    {
        return $this->belongsTo(Team::class, 'team_id', 'id');
    }
}
