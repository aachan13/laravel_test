<?php

namespace App\Rules;

use App\Models\Pegawai;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class BatasJumlahKasbon implements Rule, DataAwareRule
{
    /**
     * All of the data under validation.
     *
     * @var array
     */
    protected $data = [];

    /**
     * Set the data under validation.
     *
     * @param  array  $data
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    
    public function passes($attribute, $value)
    {
        $pegawai = Pegawai::find($this->data['pegawai_id'] ?? null);

        if(isset($pegawai)){
            $kasbonBulanIni = $pegawai->kasbon()->filterKasbon(now()->format('Y-m'))->sum('total_kasbon');
            if($kasbonBulanIni + $value > $pegawai->total_gaji / 2){
                return false;
            }
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Total kasbon pada bulan ini tidak boleh melewati setengah gaji anda.';
    }
}
