<?php

namespace App\Http\Controllers;

use App\Models\Pipeline;
use App\Http\Requests\StorePipelineRequest;
use App\Http\Requests\UpdatePipelineRequest;
use Illuminate\Process\Pipe;

class PipelineController extends Controller
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
    public function store(StorePipelineRequest $request)
    {
        //
            # code...
            //return $request;
            $pipe=new Pipeline();
            $pipe->tipo=$request->tipo;
            $pipe->funcion=$request->funcion;
            $pipe->gestion=$request->gestion;
            $pipe->diametro=$request->diametro;
            $pipe->material=$request->material;
            $pipe->profundidad=$request->profundidad;
            $pipe->origen=$request->origen;
            $pipe->destino=$request->destino;
            $pipe->sewer_id=$request->sewer_id;
            $pipe->save();
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        return Pipeline::where('sewer_id',$id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pipeline $pipeline)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePipelineRequest $request, Pipeline $pipeline)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $pipe=Pipeline::find($id);
        $pipe->delete();
    }
}
