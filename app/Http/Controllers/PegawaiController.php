<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetPegawaiRequest;
use App\Http\Requests\StorePegawaiRequest;
use App\Http\Resources\PegawaiResource;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(GetPegawaiRequest $request){
        
        return PegawaiResource::collection(Pegawai::paginate());
    }

    public function store(StorePegawaiRequest $request){
        
        $pegawai = Pegawai::create($request->validated());

        return new PegawaiResource($pegawai);
    }
}
