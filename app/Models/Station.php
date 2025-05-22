<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{

    protected $table = "station";
    protected $primaryKey = "station_id";
    public $timestamps = false;

    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }
}
