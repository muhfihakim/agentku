<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'department_id',
        'device_token',
        'device_info',
        'os_info',
        'status',
        'last_active_at',
    ];

    protected $casts = [
        'last_active_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
