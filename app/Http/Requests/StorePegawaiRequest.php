<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePegawaiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => 'bail|required|string|unique:pegawai,nama|max:10',
            'tanggal_masuk' => 'bail|required|date|before:now',
            'total_gaji' => 'bail|required|integer|min:4000000|max:10000000'
        ];
    }
}
