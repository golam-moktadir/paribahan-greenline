<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /** @use HasFactory<\Database\Factories\ImageFactory> */
    use HasFactory;

    protected $table = "image";

    protected $primaryKey = "image_id";

    protected $fillable = [
        "image_id",
        "image_description",
        "image_bin_data",
        "image_name",
        "image_size",
        "image_type",
        "image_location"
    ];
}
