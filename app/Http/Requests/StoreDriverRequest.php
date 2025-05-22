<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
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
        $imageRule = 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:512|dimensions:min_width=600,min_height=400,max_width=800,max_height=600';

        return [
            'transport_id' => 'required|integer|exists:transport,transport_id',
            'department_id' => 'required|integer|exists:department,department_id',
            'full_name' => 'required|string|min:4|max:255|regex:/^[A-Za-z. ]+$/',
            'father_name' => 'required|string|min:4|max:255|regex:/^[A-Za-z. ]+$/',
            'birth_date' => 'required|date|before_or_equal:' . now()->subYears(15)->format('Y-m-d'),
            'phone' => 'required|string|max:11|regex:/^0[0-9]{6,10}$/|unique:drivers,phone',
            'id_no' => 'nullable|string|min:4|max:20|unique:drivers,id_no',
            'nid_no' => 'required|string|min:8|max:20|regex:/^[0-9]+$/|unique:drivers,nid_no',
            'driving_license_no' => 'required|string|min:8|max:20|regex:/^[A-Z0-9]+$/|unique:drivers,driving_license_no',
            'insurance_no' => 'nullable|string|min:8|max:30|regex:/^[A-Z0-9]+$/|unique:drivers,insurance_no',
            'present_address' => 'required|string|min:10|max:255',
            'permanent_address' => 'required|string|min:10|max:255',
            'pre_experience' => 'required|integer|min:0|max:75',
            'joining_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $birthdate = $this->input('birth_date');
                    if ($birthdate) {
                        $minJoinDate = \Carbon\Carbon::parse($birthdate)->addYears(15);
                        if (\Carbon\Carbon::parse($value)->lt($minJoinDate)) {
                            $fail('The joining date must be at least 15 years after the birthdate.');
                        }
                    }
                },
            ],
            'status' => 'required|numeric|between:0,8',
            'reference' => 'required|string|min:4|max:100',
            'nid_front_attachment' => $imageRule,
            'nid_back_attachment' => $imageRule,
            'driving_license_front_attachment' => $imageRule,
            'driving_license_back_attachment' => $imageRule,
            'avatar_url' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:512',
            'insurance_attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:512',
        ];

    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        $userId = auth()->id() ?? 1; // fallback for unauthenticated users

        $uploadPaths = [
            'avatar_url' => 'assets/uploads/drivers/avatars/',
            'nid_front_attachment' => 'assets/uploads/drivers/nid/',
            'nid_back_attachment' => 'assets/uploads/drivers/nid/',
            'driving_license_front_attachment' => 'assets/uploads/drivers/licenses/',
            'driving_license_back_attachment' => 'assets/uploads/drivers/licenses/',
            'insurance_attachment' => 'assets/uploads/drivers/insurance/',
        ];

        foreach ($uploadPaths as $field => $baseDirectory) {
            if ($this->hasFile($field)) {
                $file = $this->file($field);

                $fileName = now()->format('YmdHis') . '_' . $field . '.' . $file->getClientOriginalExtension();

                // Upload path based on user ID
                $userDirectory = $baseDirectory . $userId . '/';
                $destinationPath = public_path($userDirectory);

                // Ensure the directory exists
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Move and save the file
                $file->move($destinationPath, $fileName);
                $validated[$field] = $userDirectory . $fileName;
            }
        }

        return $validated;
    }

}
