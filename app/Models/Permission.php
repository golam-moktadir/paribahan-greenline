<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    /** @use HasFactory<\Database\Factories\PermissionFactory> */
    use HasFactory;

    protected $table = "permission";

    protected $primaryKey = "permission_id";

    protected $fillable = [
        "permission_id",
        "employee_id",
        "page_id",
        "permission_view",
        "permission_insert",
        "permission_update",
        "permission_delete",
        "permission_saved_by",
        "permission_save_status",
        "permission_time_stamp"
    ];
}
