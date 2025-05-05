<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageCatagory extends Model
{
    /** @use HasFactory<\Database\Factories\PageCatagoryFactory> */
    use HasFactory;

    protected $table = "page_catagory";

    protected $primaryKey = "page_catagory_id";

    protected $fillable = [
        "page_catagory_id",
        "page_catagory_type",
        "page_catagory_saved_by",
        "page_catagory_save_status",
        "page_catagory_timestamp",
    ];

}
