<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivMember extends Model
{
    /** @use HasFactory<\Database\Factories\PrivMemberFactory> */
    use HasFactory;

    protected $table = "priv_member";

    protected $primaryKey = "priv_member_id";

    protected $fillable = [
        "priv_member_id",
        "priv_member_name",
        "priv_member_sl_no",
        "priv_member_father",
        "priv_member_spouse",
        "priv_member_occupation_id",
        "priv_member_designation_id",
        "priv_member_office_institute",
        "priv_member_address",
        "priv_member_phone_office",
        "priv_member_phone_mobile",
        "priv_member_phone_residence",
        "priv_member_blood",
        "priv_member_date",
        "priv_member_saved_by",
        "priv_member_save_status",
        "priv_member_timestamp",
        "priv_member_transport_id",
        "general_member_id",
        "pic_name"
    ];
}
