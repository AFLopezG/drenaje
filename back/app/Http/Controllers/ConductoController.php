<?php

namespace App\Http\Controllers;

use App\Models\Conducto;
use App\Http\Requests\StoreConductoRequest;
use App\Http\Requests\UpdateConductoRequest;

class ConductoController extends Controller
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
    public function store(StoreConductoRequest $request)
    {
        //
        $conducto=new Conducto();
        $conducto->tipo=$request->tipo;
        $conducto->material=$request->material;
        $conducto->largo=$request->largo;
        $conducto->ancho=$request->ancho;
        $conducto->alto=$request->alto;
        $conducto->diametro=$request->alto;
        $conducto->profundidad=$request->profundidad;
        $conducto->origen=$request->origen;
        $conducto->destino=$request->destino;
        $conducto->sewer_id=$request->sewer_id;
        $conducto->save();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        return Conducto::where('sewer_id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Conducto $conducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateConductoRequest $request, Conducto $conducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $conducto= Conducto::find($id);
        $conducto->delete();
    }
}
