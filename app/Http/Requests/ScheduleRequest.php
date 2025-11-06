<?php
// app/Http/Requests/ScheduleRequest.php

namespace App\Http\Requests; // <-- INI DIA PERBAIKANNYA

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Diasumsikan semua admin yang terautentikasi boleh melakukan ini
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'], // Judul wajib diisi
            'description' => ['nullable', 'string'], // Deskripsi tidak wajib
            'start_time' => ['required', 'date'], // Waktu mulai wajib, harus format tanggal
            'end_time' => ['required', 'date', 'after:start_time'], // Waktu selesai wajib, dan harus SETELAH start_time
        ];
    }
}