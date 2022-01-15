<?php

namespace App\Http\Requests;

use App\Models\Pegawai;
use App\Rules\BatasJumlahKasbon;
use App\Rules\MaksimalPengajuanKasbon;
use App\Rules\MinimalBekerja;
use Illuminate\Foundation\Http\FormRequest;

class StoreKasbonRequest extends FormRequest
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
            'pegawai_id' => [
                'bail',
                'required', 
                'integer', 
                'exists:pegawai,id', 
                new MinimalBekerja(),
                new MaksimalPengajuanKasbon()
            ],
            'total_kasbon' => ['bail', 'required', 'integer', new BatasJumlahKasbon()]
        ];
    }
}
