<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    /** @use HasFactory<\Database\Factories\MemberFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "member";

    protected $primaryKey = "member_id";

    protected $fillable = [
        "member_type_id",
        "member_login",
        "member_password",
        "member_new_password",
        "member_email",
        "member_activation_id",
        "member_save_status",
        "pass_changed",
    ];

    protected $hidden = [
        'member_password',
        'member_new_password',
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected function casts(): array
    {
        return [
            'member_password' => 'hashed',
            'member_new_password' => 'hashed',
        ];
    }


    // Relationships
    public function memberType()
    {
        return $this->belongsTo(MemberType::class, 'member_type_id', 'member_type_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'employee_id', 'member_id');
    }



}
