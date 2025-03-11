<?php

namespace App\Http\Controllers;

use App\Models\Sewer;
use App\Http\Requests\StoreSewerRequest;
use App\Http\Requests\UpdateSewerRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SewerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function listSewer(Request $request){
        return Sewer::where('user_id',$request->user()->id)->get();
    }   

    public function listMatPl(){
        return DB::SELECT("SELECT distinct(material) from sewers");
    }

    public function listRasPl(){
        return DB::SELECT("SELECT distinct(rasante) from sewers");
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSewerRequest $request)
    {
        //
        $sewer = new Sewer();
        $sewer->lng=$request->lng;
        $sewer->lat=$request->lat;
        $sewer->elevacion=$request->elevacion;
        $sewer->ubicacion=$request->ubicacion;
        $sewer->codigo=strtoupper($request->codigo);
        $sewer->altura=$request->altura;
        $sewer->tipo=$request->tipo;
        $sewer->rasante=strtoupper($request->rasante);
        $sewer->material=strtoupper($request->material);
        $sewer->diametro=$request->diametro;
        $sewer->altapa=$request->altapa;
        $sewer->tiptapa=$request->tiptapa;
        $sewer->estado=$request->estado;
        $sewer->fecha=$request->fecha;
        $sewer->estadotapa=$request->estadotapa;
        $sewer->apertura=$request->apertura;
        $sewer->drenaje=$request->drenaje;
        $sewer->estadoci=$request->estadoci;
        $sewer->aro=$request->aro;
        $sewer->paredes=$request->paredes;
        $sewer->solera=$request->solera;
        $sewer->condicion=$request->condicion;
        $sewer->sedimento=$request->sedimento;
        $sewer->escalon=$request->escalon;
        $sewer->observacion=$request->observacion;
        $sewer->user_id=$request->user()->id;
        $sewer->save();

        DB::SELECT("UPDATE sewers set geom=ST_MakePoint(lng,lat) where id=$sewer->id");

       
    }

    /**
     * Display the specified resource.
     */
    public function show(Sewer $sewer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sewer $sewer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSewerRequest $request, Sewer $sewer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sewer $sewer)
    {
        //
    }
    public function listDiametro(){
        return DB::SELECT("SELECT medida from diametro3");
    }

}
