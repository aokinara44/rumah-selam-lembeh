<?php
// app/Http/Requests/TransactionRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Kita asumsikan semua admin yang sudah login boleh melakukan ini.
        // Keamanan sudah ditangani oleh middleware 'auth' di file routes.
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
            'date' => ['required', 'date'], // Tanggal wajib diisi dan harus format tanggal
            'description' => ['required', 'string', 'max:255'], // Deskripsi wajib diisi, maks 255 karakter
            'amount' => ['required', 'numeric', 'min:0'], // Jumlah wajib diisi, harus angka, dan tidak boleh minus
            'type' => ['required', 'in:income,expense'], // Tipe wajib diisi, dan harus 'income' atau 'expense'
        ];
    }
}