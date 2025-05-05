<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class StoreEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // return Auth::check(); // Only authenticated users can create employees
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
            'work_group_id' => 'required|integer|exists:work_group,work_group_id',
            'employee_name' => 'required|string|min:4|max:100|regex:/^[A-Za-z. ]+$/',
            'employee_birth_date' => 'required|date|before_or_equal:' . now()->subYears(15)->toDateString(),
            'employee_joining_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $birthDate = $this->employee_birth_date;
                    $joiningDate = $value;

                    if ($birthDate && $joiningDate) {
                        $birth = \Carbon\Carbon::parse($birthDate);
                        $joining = \Carbon\Carbon::parse($joiningDate);

                        if ($joining->lessThan($birth)) {
                            $fail('Joining date cannot be before birth date.');
                        } elseif ($birth->diffInYears($joining) < 15) {
                            $fail('Employee must be at least 15 years old at the time of joining.');
                        }
                    }
                },
            ],
            'employee_present_address' => 'required|string|max:255',
            'employee_permanent_address' => 'required|string|max:255',
            'employee_phone' => 'nullable|regex:/^\d{6,11}$/',
            'employee_reference' => 'nullable|string|min:4|max:100',
            'employee_pre_experience' => 'nullable|integer|min:0|max:75',
            'employee_signature' => 'nullable|string|min:4|max:20',
            'employee_activation_id' => 'required|string|max:100',
            'employee_saved_by' => 'required|integer|exists:member,member_id',
            'employee_save_status' => 'nullable|numeric|in:0,1',
            'can_cancel_sold' => 'numeric|in:0,1',
            'can_book' => 'numeric|in:0,1',
            'can_sell_complimentary' => 'numeric|in:0,1',
            'can_gave_discount' => 'nullable|numeric|in:0,1',
            'max_discount' => 'required|numeric|min:0',
            'can_cancel_web_ticket' => 'nullable|numeric|in:0,1',
            'employee_identity' => 'nullable|min:4|max:10|regex:/^[A-Z0-9]+$/|unique:employee,employee_identity',
            'email' => 'nullable|email|min:4|max:255|unique:employee,email',
            'nid_no' => 'nullable|string|min:8|max:20|unique:employee,nid_no',
            'birth_no' => 'nullable|string|min:8|max:20|unique:employee,birth_no',
            'avatar_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024', // 1MB in kilobytes
        ];
    }

    public function validated($key = null, $default = null)
    {
        // Get the validated data
        $validated = parent::validated();

        // Initialize file path variable
        $filePath = null;

        // Check if the file 'avatar_url' exists in the request
        if ($this->hasFile('avatar_url')) {
            $image = $this->file('avatar_url');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $filePath = 'assets/uploads/employees/' . $fileName;
            $image->move(public_path('assets/uploads/employees/'), $fileName);
        }

        return array_merge($validated, [
            'avatar_url' => $filePath,
            'employee_saved_by' => 1, // current auth user id
            'employee_activation_id' => $this->input('employee_activation_id', Str::uuid()),
        ]);
    }

    public function messages(): array
    {
        return [
            'employee_id.required' => 'Member is required.',
            'employee_id.integer' => 'Invalid member.',
            'employee_id.exists' => 'Selected member does not exist.',

            'transport_id.required' => 'Transport is required.',
            'transport_id.integer' => 'Invalid transport selection.',
            'transport_id.exists' => 'Selected transport does not exist.',

            'department_id.required' => 'Department is required.',
            'department_id.integer' => 'Invalid department selection.',
            'department_id.exists' => 'Selected department does not exist.',

            'work_group_id.required' => 'Work group is required.',
            'work_group_id.integer' => 'Invalid work group selection.',
            'work_group_id.exists' => 'Selected work group does not exist.',

            'employee_name.required' => 'Employee name is required.',
            'employee_name.min' => 'Employee name must be at least 4 characters.',
            'employee_name.max' => 'Employee name may not exceed 100 characters.',
            'employee_name.regex' => 'Employee name may only contain letters, spaces, and hyphens.',
            'employee_birth_date.required' => 'The birth date is required.',
            'employee_birth_date.date' => 'Please enter a valid date for the birth date.',
            'employee_birth_date.before_or_equal' => 'The employee must be at least 15 years old.',
            'employee_joining_date.date' => 'Joining date must be a valid date.',
            'employee_joining_date.after_or_equal' => 'Joining date must be after or equal to birth date.',
            'employee_present_address.required' => 'Present address is required.',
            'employee_present_address.max' => 'Present address may not exceed 255 characters.',
            'employee_permanent_address.required' => 'Permanent address is required.',
            'employee_permanent_address.max' => 'Permanent address may not exceed 255 characters.',
            'employee_phone.required' => 'Phone number is required.',
            'employee_phone.regex' => 'The phone number must be 6 to 11 digits long and contain only numbers.',
            'employee_reference.required' => 'Reference is required.',
            'employee_reference.min' => 'Reference must be at least 3 characters.',
            'employee_reference.max' => 'Reference may not exceed 100 characters.',
            'employee_pre_experience.integer' => 'Experience must be a number.',
            'employee_pre_experience.min' => 'Experience must be at least 0.',
            'employee_pre_experience.max' => 'Experience may not exceed 75 years.',
            'employee_signature.min' => 'Signature must be at least 3 characters.',
            'employee_signature.max' => 'Signature may not exceed 30 characters.',
            'employee_signature.nullable' => 'Signature is optional.',

            'employee_activation_id.required' => 'Activation id is required.',
            'employee_activation_id.string' => 'Activation id must be a valid string.',
            'employee_activation_id.max' => 'Activation id may not exceed 100 characters.',
            'employee_saved_by.required' => 'Activation id is required.',
            'employee_saved_by.integer' => 'Activation id must be a valid string.',
            'employee_saved_by.exists' => 'Member does not exist',
            'employee_save_status.numeric' => 'Save status must be a number.',
            'employee_save_status.in' => 'Save status must be 0 (draft) or 1 (active).',

            'can_cancel_sold.in' => 'Invalid cancel permission option.',
            'can_book.in' => 'Invalid book permission option.',
            'can_sell_complimentary.in' => 'Invalid complimentary sale option.',
            'can_gave_discount.in' => 'Invalid discount permission option.',
            'max_discount.numeric' => 'Max discount must be a number.',
            'max_discount.min' => 'Max discount must be at least 0.',
            'can_cancel_web_ticket.in' => 'Invalid cancel web ticket option.',

            'employee_identity.regex' => 'The employee identity must contain only uppercase letters and numbers.',

            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'email.min' => 'Signature must be at least 3 characters.',
            'email.max' => 'Signature may not exceed 255 characters.',

            'nid_no.nullable' => 'The NID number is optional.',
            'nid_no.string' => 'The NID number must be a valid string.',
            'nid_no.min' => 'The NID number must be at least 8 characters.',
            'nid_no.max' => 'The NID number may not be more than 20 characters.',
            'nid_no.unique' => 'This NID number is already in use.',

            'birth_no.nullable' => 'The Birth Reg. number is optional.',
            'birth_no.string' => 'The Birth Reg. number must be a valid string.',
            'birth_no.min' => 'The Birth Reg. number must be at least 8 characters.',
            'birth_no.max' => 'The Birth Reg. number may not be more than 20 characters.',
            'birth_no.unique' => 'This Birth Reg. number is already in use.',

            'avatar_url.nullable' => 'Avatar image is optional.',
            'avatar_url.image' => 'The avatar must be a valid image file.',
            'avatar_url.mimes' => 'The avatar image must be a file of type: jpg, jpeg, png, webp.',
            'avatar_url.max' => 'The avatar image must not be larger than 1MB.',
        ];
    }

}
