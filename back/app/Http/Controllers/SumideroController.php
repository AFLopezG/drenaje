<?php

namespace App\Http\Controllers;

use App\Models\Sumidero;
use App\Http\Requests\StoreSumideroRequest;
use App\Http\Requests\UpdateSumideroRequest;

class SumideroController extends Controller
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
    public function store(StoreSumideroRequest $request)
    {
        //
        $sumidero=new Sumidero();
        $sumidero->material=$request->material;
        $sumidero->tapa=$request->tapa;
        $sumidero->estado=$request->estado;
        $sumidero->apertura=$request->apertura;
        $sumidero->sedimento=$request->sedimento;
        $sumidero->altsed=$request->altsed;
        $sumidero->condicion=$request->condicion;
        $sumidero->sewer_id=$request->sewer_id;
        $sumidero->save();

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        return Sumidero::where('sewer_id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sumidero $sumidero)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSumideroRequest $request, Sumidero $sumidero)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        //
        $sumidero=Sumidero::find($id);
        $sumidero->delete();
    }
}
