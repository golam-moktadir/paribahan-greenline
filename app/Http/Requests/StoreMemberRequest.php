<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
        // return $this->user()->can('create', \App\Models\Member::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'member_type_id' => 'required|integer|exists:member_type,member_type_id',
            'member_login' => 'required|string|min:4|max:20|unique:member,member_login|alpha_num',
            'member_new_password' => [
                'required',
                'string',
                'max:20',
                'confirmed',
                Password::min(6)
                    ->letters()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(), // Checks if password appears in data leaks
            ],
            'member_email' => 'nullable|email|max:255|unique:member,member_email',
            'member_activation_id' => 'required|string|max:255',
            // 'member_save_status' => 'required|numeric|in:0,1',
            'pass_changed' => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            // Member Type
            'member_type_id.required' => 'Please select a member type.',
            'member_type_id.integer' => 'Member type must be a valid number.',
            'member_type_id.exists' => 'The selected member type is invalid.',
            // Login
            'member_login.required' => 'Username is required.',
            'member_login.min' => 'Username must be at least 4 characters.',
            'member_login.max' => 'Username cannot exceed 20 characters.',
            'member_login.unique' => 'This username is already taken.',
            'member_login.alpha_num' => 'Username can only contain letters and numbers.',
            // Password
            'member_new_password.required' => 'Password is required.',
            'member_new_password.max' => 'Password cannot exceed 20 characters.',
            'member_new_password.confirmed' => 'Password confirmation does not match.',
            'member_new_password.min' => 'Password must be at least 6 characters.',
            'member_new_password.letters' => 'Password must include at least one letter.',
            'member_new_password.numbers' => 'Password must include at least one number.',
            'member_new_password.symbols' => 'Password must include at least one symbol.',
            // Email
            'member_email.email' => 'Please enter a valid email address.',
            'member_email.max' => 'Email cannot exceed 255 characters.',
            'member_email.unique' => 'This email is already registered.',
            // Activation Status
            'member_activation_id.required' => 'Activation ID is required',
            'member_activation_id.max' => 'Activation ID cannot exceed 255 characters.',
            // Save Status
            'member_save_status.required' => 'Save status is required',
            'member_save_status.numeric' => 'Save status must be 0 or 1',
            'member_save_status.in' => 'Save status must be 0 (not saved) or 1 (saved)',
            // Password Changed
            'pass_changed.boolean' => 'Password changed status must be 0 or 1.',
        ];
    }


    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Sanitize inputs if needed (e.g., trim strings)
        $this->merge([
            'member_password' => 'test',
            'member_activation_id' => 'a1', // Fixed 
            'member_login' => trim($this->input('member_login', '')),
            'member_email' => $this->input('member_email') ? trim($this->input('member_email')) : null,
            'pass_changed' => $this->boolean('pass_changed', false),
        ]);
    }

}