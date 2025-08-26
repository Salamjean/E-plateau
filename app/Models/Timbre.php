<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timbre extends Model
{
    protected $fillable = [
        'nombre_timbre',
        'finance_id',
    ];

    public function finance()
    {
        return $this->belongsTo(Finance::class); 
    }
}
