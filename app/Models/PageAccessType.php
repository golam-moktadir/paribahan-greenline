<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageAccessType extends Model
{
    /** @use HasFactory<\Database\Factories\PageAccessTypeFactory> */
    use HasFactory;

    protected $table = "page_access_type";

    protected $primaryKey = "page_access_type_id";

    protected $fillable = [
        "page_access_type_id",
        "page_access_type_name",
        "page_catagory_id",
        "page_access_type_url",
        "page_access_type_saved_by",
        "page_access_type_save_status",
        "page_access_type_timestamp",
    ];
}
