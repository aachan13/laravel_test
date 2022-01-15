<?php

namespace App\Rules;

use App\Models\Pegawai;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;

class MinimalBekerja implements Rule, DataAwareRule
{
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
            if($pegawai->tanggal_masuk->diffInYears(now()) < 1){
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
        return 'Minimal harus 1 tahun bekerja.';
    }
}
