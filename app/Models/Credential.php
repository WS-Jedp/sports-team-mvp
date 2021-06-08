<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credential extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function Users()
    {
        return $this->hasMany(User::class, 'credential_id', 'id');
    }
}
