<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class UpdateEmployeeRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $employeeId = $this->route('employee');

        return [
            'transport_id' => 'required|integer|exists:transport,transport_id',
            'department_id' => 'required|integer|exists:department,department_id',
            'work_group_id' => 'required|integer|exists:work_group,work_group_id',
            'employee_name' => 'required|string|min:3|max:100|regex:/^[\pL\s\-]+$/u',
            'employee_login' => "required|string|min:3|max:50|unique:employee,employee_login,{$employeeId},employee_id|regex:/^[a-zA-Z0-9_\-]+$/",
            'employee_new_password' => [
                'nullable',
                'string',
                'max:50',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
            ],
            'employee_birth_date' => 'required|date',
            'employee_joining_date' => [
                'required',
                'date',
                'after_or_equal:employee_birth_date',
                function ($attribute, $value, $fail) {
                    if ($this->employee_birth_date && $value) {
                        $birth = \Carbon\Carbon::parse($this->employee_birth_date);
                        $joining = \Carbon\Carbon::parse($value);
                        if ($birth->diffInYears($joining) < 15) {
                            $fail('Employee must be at least 15 years old at the time of joining.');
                        }
                    }
                },
            ],
            'employee_permanent_address' => 'required|string|max:255',
            'employee_present_address' => 'required|string|max:255',
            'employee_phone' => 'required|regex:/^0[0-9]{9,10}$/|max:11',
            'employee_pre_experience' => 'nullable|integer|min:0|max:75',
            'employee_reference' => 'required|string|min:3|max:100',
            'employee_save_status' => 'required|numeric|in:0,1',
            'employee_signature' => 'nullable|string|min:3|max:30',
            'can_cancel_sold' => 'numeric|in:0,1',
            'can_book' => 'numeric|in:0,1',
            'can_sell_complimentary' => 'numeric|in:0,1',
            'can_gave_discount' => 'nullable|numeric|in:0,1',
            'max_discount' => 'nullable|numeric|min:0',
            'can_cancel_web_ticket' => 'nullable|numeric|in:0,1',
            'email' => "nullable|email|min:3|max:255|unique:employee,email,{$employeeId},employee_id",
            'nid_no' => "nullable|string|min:8|max:20|unique:employee,nid_no,{$employeeId},employee_id",
            'birth_no' => "nullable|string|min:8|max:20|unique:employee,birth_no,{$employeeId},employee_id",
            'avatar_url' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:1024',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    public function prepareForValidation()
    {
        $this->merge([
            'employee_saved_by' => auth()->id() ?? 1,
            'employee_activation_id' => $this->employee_activation_id ?? (string) Str::uuid(),
        ]);
    }

    /**
     * Get the validated data with additional fields.
     */
    // public function validated($key = null, $default = null)
    // {
    //     $validated = parent::validated();

    //     return array_merge($validated, [
    //         'employee_saved_by' => $this->input('employee_saved_by', auth()->id() ?? 1),
    //         'employee_activation_id' => $this->input('employee_activation_id', Str::uuid()),
    //     ]);
    // }


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
            'employee_saved_by' => $this->input('employee_saved_by', 1, ),
            'employee_activation_id' => $this->input('employee_activation_id', Str::uuid()),
        ]);
    }


    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
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
            'employee_name.min' => 'Employee name must be at least 3 characters.',
            'employee_name.max' => 'Employee name may not exceed 100 characters.',
            'employee_name.regex' => 'Employee name may only contain letters, spaces, and hyphens.',
            'employee_login.required' => 'Employee login is required.',
            'employee_login.min' => 'Login must be at least 3 characters.',
            'employee_login.max' => 'Login may not exceed 50 characters.',
            'employee_login.unique' => 'This login name is already taken.',
            'employee_login.regex' => 'Login may only contain letters, numbers, underscores, or hyphens.',
            'employee_new_password.string' => 'Password must be a valid string.',
            'employee_new_password.max' => 'Password may not exceed 50 characters.',
            'employee_new_password.*' => 'Password must be at least 8 characters and include uppercase, lowercase, a number, and a symbol.',
            'employee_birth_date.required' => 'Birth date is required.',
            'employee_birth_date.date' => 'Birth date must be a valid date.',
            'employee_joining_date.required' => 'Joining date is required.',
            'employee_joining_date.date' => 'Joining date must be a valid date.',
            'employee_joining_date.after_or_equal' => 'Joining date must be after or equal to birth date.',
            'employee_permanent_address.required' => 'Permanent address is required.',
            'employee_permanent_address.max' => 'Permanent address may not exceed 255 characters.',
            'employee_present_address.required' => 'Present address is required.',
            'employee_present_address.max' => 'Present address may not exceed 255 characters.',
            'employee_phone.required' => 'Phone number is required.',
            'employee_phone.regex' => 'Phone must start with 0 and contain 10–11 digits.',
            'employee_phone.max' => 'Phone number may not exceed 11 digits.',
            'employee_pre_experience.integer' => 'Experience must be a number.',
            'employee_pre_experience.min' => 'Experience must be at least 0.',
            'employee_pre_experience.max' => 'Experience may not exceed 50 years.',
            'employee_reference.required' => 'Reference is required.',
            'employee_reference.min' => 'Reference must be at least 3 characters.',
            'employee_reference.max' => 'Reference may not exceed 100 characters.',
            'employee_save_status.required' => 'Save status is required.',
            'employee_save_status.numeric' => 'Save status must be a number.',
            'employee_save_status.in' => 'Save status must be 0 (draft) or 1 (active).',
            'employee_signature.min' => 'Signature must be at least 3 characters.',
            'employee_signature.max' => 'Signature may not exceed 30 characters.',
            'can_cancel_sold.in' => 'Invalid cancel permission option.',
            'can_book.in' => 'Invalid book permission option.',
            'can_sell_complimentary.in' => 'Invalid complimentary sale option.',
            'can_gave_discount.in' => 'Invalid discount permission option.',
            'max_discount.numeric' => 'Max discount must be a number.',
            'max_discount.min' => 'Max discount must be at least 0.',
            'can_cancel_web_ticket.in' => 'Invalid web ticket cancel option.',
            'email.unique' => 'This email is already taken.',
            'nid_no.unique' => 'This NID number is already taken.',
            'birth_no.unique' => 'This birth number is already taken.',
            'avatar_url.image' => 'The file must be an image.',
            'avatar_url.mimes' => 'The image must be a JPG, JPEG, PNG, or WEBP file.',
            'avatar_url.max' => 'The image may not exceed 1MB.',
        ];
    }
}