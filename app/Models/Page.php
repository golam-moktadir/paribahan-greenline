<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    /** @use HasFactory<\Database\Factories\PageFactory> */
    use HasFactory;

    protected $table = "page";

    protected $primaryKey = "page_id";

    protected $fillable = [
        "page_id",
        "page_name",
        "page_title",
        "page_is_admin",
        "page_desc",
        "page_view_level",
        "page_saved_by",
        "page_save_status",
        "page_time_stamp",
        "page_type_id",
    ];
}
