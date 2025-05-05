<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkGroup extends Model
{
    /** @use HasFactory<\Database\Factories\WorkGroupFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "work_group";

    protected $primaryKey = "work_group_id";

    protected $fillable = [
        "work_group_id",
        "work_group_name",
        "work_group_saved_by",
        "work_group_save_status",
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'work_group_id', 'work_group_id');
    }

}
