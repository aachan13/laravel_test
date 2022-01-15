<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetKasbonRequest extends FormRequest
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
            'bulan' => 'required|string|date_format:Y-m',
            'belum_disetujui' => 'nullable|integer',
            'page' => 'nullable|integer'
        ];
    }
}
