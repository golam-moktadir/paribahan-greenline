<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubPage extends Model
{
    /** @use HasFactory<\Database\Factories\SubPageFactory> */
    use HasFactory;

    protected $table = "subpage";

    protected $primaryKey = "subpage_id";

    protected $fillable = [
        "subpage_id",
        "page_id",
        "subpage_name",
        "subpage_title",
        "subpage_saved_by",
        "subpage_save_status",
        "subpage_timestamp"
    ];
}
