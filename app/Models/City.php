<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "city";

    protected $primaryKey = "city_id";

    protected $fillable = [
        "city_id",
        "city_name",
        "city_code",
        "city_image_name",
        "sms_available",
        "city_saved_by",
        "city_save_status",
        "city_timestamp",
    ];

    public function stations(){
        return $this->hasMany(Station::class, 'city_id');
    }

}
