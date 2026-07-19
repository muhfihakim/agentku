<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecurityAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'type',
        'description',
        'device_details',
        'logged_at'
    ];

    protected $casts = [
        'device_details' => 'array',
        'logged_at' => 'datetime'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
