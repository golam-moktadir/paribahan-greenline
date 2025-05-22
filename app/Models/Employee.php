<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "employee";

    protected $primaryKey = "employee_id";

    protected $fillable = [
        'employee_id',
        'transport_id',
        'department_id',
        'work_group_id',
        'employee_name',
        'employee_login',
        'employee_password',
        'employee_new_password',
        'employee_birth_date',
        'employee_joining_date',
        'employee_permanent_address',
        'employee_present_address',
        'employee_phone',
        'employee_pre_experience',
        'employee_reference',
        'employee_saved_by',
        'employee_save_status',
        'employee_timestamp',
        'employee_activation_id',
        'employee_signature',
        'can_cancel_sold',
        'can_book',
        'can_sell_complimentary',
        'can_gave_discount',
        'max_discount',
        'can_cancel_web_ticket',
        'employee_identity',
        'nid_no',
        'birth_no',
        'avatar_url',
    ];

    protected $hidden = [
        'employee_password',
        'employee_new_password',
    ];

    protected $casts = [
        // 'employee_new_password' => 'hashed', 
        'employee_birth_date' => 'date',
        'employee_joining_date' => 'date',
        // 'can_cancel_sold' => 'boolean',
        // 'can_book' => 'boolean',
        // 'can_sell_complimentary' => 'boolean',
        // 'can_gave_discount' => 'boolean',
    ];

    protected $dates = [
        'deleted_at',
    ];


    // Relationships
    public function member()
    {
        return $this->belongsTo(Member::class, 'employee_id', 'member_id');
    }


    /**
     * Get the department that owns the employee.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    /**
     * Get the work group that owns the employee.
     */
    public function workGroup()
    {
        return $this->belongsTo(WorkGroup::class, 'work_group_id', 'work_group_id');
    }

    /**
     * Get the transport that owns the employee.
     */
    public function transport()
    {
        return $this->belongsTo(Transport::class, 'transport_id', 'transport_id');
    }

    public function savedBy()
    {
        return $this->belongsTo(Member::class, 'employee_saved_by');
    }

    // public function booths(){
    //     return $this->hasMany(::class, 'city_id');
    // }

}
