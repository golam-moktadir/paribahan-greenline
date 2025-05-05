<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberType extends Model
{
    /** @use HasFactory<\Database\Factories\MemberTypeFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "member_type";

    protected $primaryKey = "member_type_id";

    protected $fillable = [
        "member_type_id",
        "member_type_name",
        "member_type_url",
        "member_type_saved_by",
        "member_type_save_status",
        "member_type_timestamp",
    ];

    protected $dates = [
        'deleted_at',
    ];
}
