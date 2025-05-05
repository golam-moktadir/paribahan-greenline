<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Department extends Model
{
    /** @use HasFactory<\Database\Factories\DepartmentFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "department";

    protected $primaryKey = "department_id";

    protected $fillable = [
        "department_id",
        "department_name",
        "department_saved_by",
        "department_save_status",
    ];

    protected $dates = [
        'deleted_at',
    ];

    // Relationships
    public function employees()
    {
        return $this->hasMany(Employee::class, 'department_id', 'department_id');
    }

}
