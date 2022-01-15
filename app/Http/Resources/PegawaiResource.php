<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PegawaiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'nama' => Str::upper(Str::before($this->nama, ' ')),
            'tanggal_masuk' => $this->tanggal_masuk->format('d-m-Y'),
            'total_gaji' => number_format($this->total_gaji, 0, '', '.')
        ];
    }
}
