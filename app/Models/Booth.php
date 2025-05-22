<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booth extends Model
{
    
    protected $table = "booth";
    protected $primaryKey = "booth_id";

    protected $fillable = [
                'booth_name',
                'booth_code',
                'transport_id',
                'station_id',
                'booth_man_in_charge_employee_id',
                'booth_address',
                'booth_phone',
                'booth_online_booking',
                'booth_pocket_counter',
                'booth_ip',
                'master_booth',
                'parent_booth',
                'server_connection_status',
                'booth_lan_ip',
                'vat_no',
                'currency',
                'booth_saved_by'
            ];

    public function station(){
        return $this->belongsTo(Station::class, 'station_id');
    }

    public function employee(){
        return $this->belongsTo(Employee::class, 'booth_man_in_charge_employee_id', 'employee_id');
    }
}
