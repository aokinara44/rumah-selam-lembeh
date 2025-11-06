<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Kita set true agar request ini bisa digunakan oleh admin yang login
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
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:phone,email,social,address,qr_code', // <-- 1. DITAMBAHKAN 'qr_code'
            'value' => 'required|string',
            'icon_svg' => 'nullable|string',
            'is_active' => 'sometimes|boolean',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Ini untuk menangani checkbox 'is_active'
        // Jika checkbox tidak dicentang, form tidak akan mengirimkan nilai 'is_active'.
        // Kode ini memastikan jika tidak dicentang, nilainya adalah 'false' (0).
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}