<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuideRequest extends FormRequest
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
            'transport_id' => 'required|integer|exists:transport,transport_id',
            'department_id' => 'required|integer|exists:department,department_id',
            'full_name' => 'required|string|min:4|max:255|regex:/^[A-Za-z. ]+$/',
            'father_name' => 'required|string|min:4|max:255|regex:/^[A-Za-z. ]+$/',
            'birth_date' => 'required|date|before_or_equal:' . now()->subYears(15)->format('Y-m-d'),
            'phone' => 'required|string|max:11|regex:/^0[0-9]{6,10}$/|unique:guides,phone',
            'id_no' => 'required|string|max:20|unique:guides,id_no',
            'nid_no' => 'required|string|min:8|max:20|regex:/^[0-9]+$/|unique:guides,nid_no',
            'insurance_no' => 'nullable|string|min:8|max:30|regex:/^[A-Z0-9]+$/|unique:guides,insurance_no',
            'present_address' => 'required|string|max:255',
            'permanent_address' => 'required|string|max:255',
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
            'status' => 'required|numeric|in:0,1,2,3,4,5,6,7,8',
            'reference' => 'required|string|min:4|max:100',
            'avatar_url' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:512',
            'nid_attachment' => 'required|file|mimes:jpg,jpeg,png,gif,pdf|max:512',
            'insurance_attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf|max:512',
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        $uploadPaths = [
            'avatar_url' => 'assets/uploads/guides/avatars/',
            'nid_attachment' => 'assets/uploads/guides/nid/',
            'insurance_attachment' => 'assets/uploads/guides/insurance/',
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
