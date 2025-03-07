<?php

namespace App\Http\Controllers;

use App\Models\Sewer;
use App\Http\Requests\StoreSewerRequest;
use App\Http\Requests\UpdateSewerRequest;

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

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSewerRequest $request)
    {
        //
        $sewer = new Sewer();

        'lng',
        'lat',
        'geom',
        'elevacion',
        'ubicacion',
        'codigo',
        'altura',
        'tipo',
        'rasante',
        'material',
        'diametro',
        'altapa',
        'tiptapa',
        'estado',
        'fecha',
        'estadotapa',
        'apertura',
        'drenaje',
        'estadoci',
        'aro',
        'paredes',
        'solera',
        'condicion',
        'sedimento',
        'escalon',
        'observacion',
        'user_id',
        
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
}
