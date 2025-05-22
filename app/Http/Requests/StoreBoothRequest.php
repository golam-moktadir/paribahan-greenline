<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoothRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'booth_name' => 'required|string',
            'booth_code' => 'numeric|max:9999',
            'transport_id' => 'required|integer',
            'station_id' => 'required|integer',
            'booth_man_in_charge_employee_id' => 'required|integer',
            'booth_address' => 'required',
            'booth_phone' => 'nullable|numeric|max:11',
            'booth_online_booking' => 'nullable',
            'booth_pocket_counter' => 'nullable',
            'booth_ip' => 'required',
            'master_booth' => 'required',
            'parent_booth' => 'nullable',
            'server_connection_status' => 'nullable',
            'booth_lan_ip' => 'nullable',
            'vat_no' => 'nullable',
            'currency' => 'nullable',           
            'booth_saved_by' => 'required|integer'
        ];
    }
}
