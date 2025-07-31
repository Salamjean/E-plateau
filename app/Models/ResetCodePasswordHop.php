<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetCodePasswordHop extends Model
{
    protected $fillable = [
        'code',
        'email',
    ];
}
