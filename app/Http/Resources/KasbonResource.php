<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class KasbonResource extends JsonResource
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
            'tanggal_diajukan' => $this->tanggal_diajukan->format('d-m-Y'),
            'tanggal_disetujui' => isset($this->tanggal_disetujui) ? $this->tanggal_disetujui->format('d-m-Y') : null,
            'nama_pegawai' => $this->pegawai->nama,
            'total_kasbon' => number_format($this->total_kasbon, 2, '', '.')
        ];
    }
}
