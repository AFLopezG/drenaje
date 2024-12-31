<?php

namespace App\Http\Controllers;

use App\Models\Detalle;
use App\Http\Requests\StoreDetalleRequest;
use App\Http\Requests\UpdateDetalleRequest;

class DetalleController extends Controller
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDetalleRequest $request)
    {
        //
        $detalle=new Detalle();
        $detalle->tipo=$request->tipo;
        $detalle->codigo=$request->codigo;
        $detalle->gestion=$request->gestion;
        $detalle->diametro=$request->diametro;
        $detalle->material=$request->material;
        $detalle->profundidad=$request->profundidad;
        $detalle->origen=$request->origen;
        $detalle->destino=$request->destino;
        $detalle->inspection_id=$request->inspection_id;
        $detalle->save();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        return Detalle::where('inspection_id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Detalle $detalle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDetalleRequest $request, Detalle $detalle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $detalle=Detalle::find($id);
        $detalle->delete();

    }
}
