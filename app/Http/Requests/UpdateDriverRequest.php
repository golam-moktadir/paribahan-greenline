<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverRequest extends FormRequest
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
        $driverId = $this->route('driver');

        $imageRule = 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:512|dimensions:min_width=600,min_height=400,max_width=800,max_height=600';

        return [
            'transport_id' => 'required|integer|exists:transport,transport_id',
            'department_id' => 'required|integer|exists:department,department_id',
            'status' => 'required|in:' . implode(',', array_keys(\App\Models\Driver::STATUSES)),
            'id_no' => 'required|string|min:4|max:20|regex:/^[A-Z0-9]+$/|unique:drivers,id_no,' . $driverId,
            'full_name' => 'required|string|min:4|max:255|regex:/^[A-Za-z. ]+$/',
            'father_name' => 'required|string|min:4|max:255|regex:/^[A-Za-z. ]+$/',
            'phone' => 'required|string|max:11|regex:/^0[0-9]{6,10}$/|unique:drivers,phone,' . $driverId,

            'birth_date' => 'required|date|before_or_equal:' . now()->subYears(15)->format('Y-m-d'),
            'nid_no' => 'required|string|min:8|max:20|regex:/^[0-9]+$/|unique:drivers,nid_no,' . $driverId,
            'driving_license_no' => 'required|string|min:8|max:20|regex:/^[A-Z0-9]+$/|unique:drivers,driving_license_no,' . $driverId,
            'insurance_no' => 'nullable|string|min:8|max:30|regex:/^[A-Z0-9]+$/|unique:drivers,insurance_no,' . $driverId,
            'pre_experience' => 'required|integer|min:0|max:75',
            'joining_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $birthDate = $this->input('birth_date');
                    if ($birthDate && \Carbon\Carbon::canBeCreatedFromFormat($birthDate, 'Y-m-d')) {
                        $minJoinDate = \Carbon\Carbon::parse($birthDate)->addYears(15);
                        if (\Carbon\Carbon::parse($value)->lessThan($minJoinDate)) {
                            $fail('The joining date must be at least 15 years after the birth date.');
                        }
                    }
                },
            ],
            'reference' => 'required|string|min:4|max:100',
            'present_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
            'avatar_url' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:512',
            'nid_front_attachment' => $imageRule,
            'nid_back_attachment' => $imageRule,
            'driving_license_front_attachment' => $imageRule,
            'driving_license_back_attachment' => $imageRule,
            'insurance_attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:512',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        $uploadPaths = [
            'avatar_url' => 'assets/uploads/drivers/avatars/',
            'nid_attachment' => 'assets/uploads/drivers/nid/',
            'driving_license_attachment' => 'assets/uploads/drivers/licenses/',
            'insurance_attachment' => 'assets/uploads/drivers/insurance/',
        ];

        foreach ($uploadPaths as $field => $directory) {
            if ($this->hasFile($field)) {
                $file = $this->file($field);
                $fileName = time() . '_' . $field . '.' . $file->getClientOriginalExtension();
                $destinationPath = public_path($directory);

                // Ensure the directory exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                $file->move($destinationPath, $fileName);
                $validated[$field] = $directory . $fileName;
            }
        }

        return $validated;
    }
}
