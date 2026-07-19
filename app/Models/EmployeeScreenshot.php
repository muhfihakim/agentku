<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeScreenshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'file_path',
        'active_window',
        'captured_at'
    ];

    protected $casts = [
        'captured_at' => 'datetime'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
