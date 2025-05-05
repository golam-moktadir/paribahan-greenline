<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transport extends Model
{
    /** @use HasFactory<\Database\Factories\TransportFactory> */
    use HasFactory, SoftDeletes;

    protected $table = "transport";

    protected $primaryKey = "transport_id";

    protected $fillable = [
        'transport_id',
        'transport_name',
        'transport_organization_name',
        'transport_short_name',
        'transport_address',
        'transport_total_station',
        'transport_total_bus',
        'transport_total_employee',
        'transport_total_route',
        'transport_city_id',
        'transport_postcode',
        'transport_date_of_establishment',
        'transport_phone',
        'transport_mobile',
        'transport_fax',
        'transport_email',
        'transport_web',
        'transport_owner_name',
        'transport_owner_phone',
        'transport_owner_mobile',
        'transport_owner_email',
        'transport_owner_fax',
        'transport_interest_1',
        'transport_interest_2',
        'transport_interest_3',
        'transport_interest_4',
        'transport_interest_5',
        'transport_interest_6',
        'transport_comments',
        'transport_administrative_login',
        'transport_administrative_password',
        'image_id',
        'transport_homepage_text',
        'transport_saved_by',
        'transport_save_status',
        'server_ip',
        'transport_rank',
        'server_lan_ip',
        'transport_code'
    ];

    protected $dates = [
        'deleted_at',
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class, 'transport_id', 'transport_id');
    }

}
