<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $connection = 'mysql';

    protected $fillable = [
        'name',
        'price',
        'agent_limit',
        'duration_days',
        'status',
    ];
}
