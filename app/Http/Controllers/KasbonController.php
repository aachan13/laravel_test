<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetKasbonRequest;
use App\Http\Requests\StoreKasbonRequest;
use App\Http\Requests\UpdateKasbonRequest;
use App\Http\Resources\KasbonResource;
use App\Jobs\UpdateMasalKasbonJob;
use App\Models\Kasbon;
use Illuminate\Http\Request;

class KasbonController extends Controller
{
    public function index(GetKasbonRequest $request){
        
        $kasbon = Kasbon::filterKasbon($request->bulan, $request->belum_disetujui)->paginate();

        return KasbonResource::collection($kasbon);
    }

    public function store(StoreKasbonRequest $request){
        
        $data = $request->validated();
        $data['tanggal_diajukan'] = now();
        $kasbon = Kasbon::create($data);

        return new KasbonResource($kasbon);
    }

    public function update(UpdateKasbonRequest $request, $id){
        
        $kasbon = Kasbon::find($id);
        $kasbon->tanggal_disetujui = now();
        $kasbon->save();
        
        return new KasbonResource($kasbon);
    }

    public function massUpdate(){
        
        $kasbon = Kasbon::filterKasbon(now()->format('Y-m'), 1)->get();
        foreach($kasbon as $bon){
            UpdateMasalKasbonJob::dispatch($bon)->delay(now()->addSecond());
        }

        return response()->json([
            count($kasbon). ' kasbon akan disetujui.'
        ]);
    }
}
