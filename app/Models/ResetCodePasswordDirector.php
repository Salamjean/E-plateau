<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetCodePasswordDirector extends Model
{
   protected $fillable = [
        'code',
        'email',
    ];
}
