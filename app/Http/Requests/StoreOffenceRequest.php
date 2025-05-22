<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOffenceRequest extends FormRequest
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
            'driver_id' => 'required|integer|exists:drivers,id',
            'offence_type' => 'required|in:' . implode(',', array_keys(\App\Models\Offence::OFFENCE_TYPES)),
            'occurrence_date' => 'required|date|before_or_equal:' . now()->format('Y-m-d'),
            'description' => 'required|string|max:250',
            'complainant_name' => 'nullable|string|min:4|max:150|regex:/^[A-Za-z. ]+$/',
            'complainant_phone' => 'nullable|string|regex:/[0-9]{6,11}$/|max:11',
            'complainant_attachments' => 'nullable|array|min:1|max:5',
            'complainant_attachments.*' => 'file|mimes:jpeg,png,jpg,gif,pdf',
        ];

    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        // Check if there are attachments in the request
        if ($this->hasFile('complainant_attachments')) {
            $filePaths = [];

            foreach ($this->file('complainant_attachments') as $file) {
                if ($file->isValid()) {

                    $mime = $file->getMimeType();
                    $sizeInKB = $file->getSize() / 1024;

                    if (in_array($mime, ['image/jpeg', 'image/png', 'image/gif']) && $sizeInKB > 512) {
                        $validated->errors()->add('complainant_attachments', 'Image files must not be greater than 512KB.');
                    }

                    if ($mime === 'application/pdf' && $sizeInKB > 1024) {
                        $validated->errors()->add('complainant_attachments', 'PDF files must not be greater than 1MB.');
                    }

                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $path = 'assets/uploads/offence_attachments/' . $fileName;

                    $file->move(public_path('assets/uploads/offence_attachments'), $fileName);

                    $filePaths[] = $path;
                }
            }

            $validated['complainant_attachments'] = $filePaths;
        }

        return $validated;
    }

}
