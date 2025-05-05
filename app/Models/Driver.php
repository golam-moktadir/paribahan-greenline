<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends Model
{
    /** @use HasFactory<\Database\Factories\DriverFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transport_id',
        'department_id',
        'full_name',
        'father_name',
        'birth_date',
        'phone',
        'id_no',
        'nid_no',
        'driving_license_no',
        'insurance_no',
        'present_address',
        'permanent_address',
        'pre_experience',
        'joining_date',
        'status',
        'reference',
        'avatar_url',
        'nid_attachment',
        'driving_license_attachment',
        'insurance_attachment',
        'created_by',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'joining_date' => 'date',
    ];

    protected $dates = [
        'deleted_at',
    ];

    public const STATUSES = [
        'active' => 'Active',
        'inactive' => 'Inactive',
        'on_leave' => 'On-Leave'
    ];

    /**
     * Get the transport that owns the driver.
     */
    public function transport()
    {
        return $this->belongsTo(Transport::class, 'transport_id', 'transport_id');
    }

    /**
     * Get the department that owns the driver.
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    /**
     * Get the creator of the driver record
     */
    public function creator()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    /**
     * Get the status label
     */
    public function getStatusLabelAttribute(): string
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }

}
