<?php

namespace App\Http\Controllers;

use App\Models\Camara;
use App\Models\Inspection;
use App\Models\Detalle;
use App\Http\Requests\StoreCamaraRequest;
use App\Http\Requests\UpdateCamaraRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class CamaraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        //return Camara::with('inspection')->get();
        $camara = DB::SELECT("SELECT c.id,c.codigo,c.lng,c.lat,c.ubicacion,i.fecha
        from camaras c inner join inspections i on c.id=i.camara_id where c.user_id=".$request->user()->id);
        return  $camara;
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
    public function store(StoreCamaraRequest $request)
    {
        //
        //return $request;
        // validar datos
        $request->validate([
            'lng' => 'required|numeric',
            'lat' => 'required|numeric',
            'elevacion' => 'required|numeric',
            'ubicacion' => 'required|string|max:255',
            'codigo' => 'required|string|max:255|unique:camaras',
            'altura' => 'nullable|numeric',
            'tipo' => 'nullable|string|max:255',
        ]);
        //detalle tenga algun dato
        if (empty($request->detalle)) {
            return response()->json(['error' => 'El detalle es requerido'], 422);
        }

        $camara = new Camara();
        $camara->lng=$request->lng;
        $camara->lat=$request->lat;
        $camara->elevacion=$request->elevacion;
        $camara->ubicacion=$request->ubicacion;
        $camara->codigo=strtoupper($request->codigo);
        $camara->altura=$request->altura;
        $camara->tipo=$request->tipo;
        $camara->rasante=strtoupper($request->rasante);
        $camara->material=strtoupper($request->material);
        $camara->diametro=$request->diametro;
        $camara->altapa=$request->altapa;
        $camara->tiptapa=$request->tiptapa;
        $camara->user_id=$request->user()->id;
        $camara->save();

        DB::SELECT("UPDATE camaras 
SET geom = ST_Transform(
              ST_SetSRID(ST_MakePoint(lng, lat), 4326), 
              32719
           )
WHERE id = $camara->id;");

        $inspec=$request->inspec;
        $inspection = new Inspection();
        $inspection->fecha=date('Y-m-d');
        $inspection->estadotapa=isset($inspec['estadotapa'])?$inspec['estadotapa']:null;
        $inspection->apertura=isset($inspec['apertura'])?$inspec['apertura']:null;
        $inspection->drenaje=isset($inspec['drenaje'])?$inspec['drenaje']:null;
        $inspection->estadoci=isset($inspec['estadoci'])?$inspec['estadoci']:null;
        $inspection->aro=isset($inspec['aro'])?$inspec['aro']:null;
        $inspection->paredes=isset($inspec['paredes'])?$inspec['paredes']:null;
        $inspection->solera=isset($inspec['solera'])?$inspec['solera']:null;
        $inspection->condicion=isset($inspec['condicion'])?$inspec['condicion']:null;
        $inspection->sedimento=isset($inspec['sedimento'])?$inspec['sedimento']:null;
        $inspection->alturasedi=isset($inspec['alturasedi'])?$inspec['alturasedi']:null;
        $inspection->estadosol=isset($inspec['estadosol'])?$inspec['estadosol']:null;
        $inspection->escalon=isset($inspec['escalon'])?$inspec['escalon']:null;
        $inspection->estadofis=isset($inspec['estadofis'])?$inspec['estadofis']:null;
        $inspection->observacion=isset($inspec['observacion'])?$inspec['observacion']:null;
        $inspection->user_id=$request->user()->id;
        $inspection->camara_id=$camara->id;
        $inspection->save();

        foreach ($request->detalle as $value) {
            # code...
            $detalle=new Detalle();
            $detalle->tipo=$value['tipo'];
            $detalle->codigo=isset($value['codigo'])?$value['codigo']:'';
            $detalle->gestion=isset($value['gestion'])?$value['gestion']:'';
            $detalle->diametro=$value['diametro'];
            $detalle->material=$value['material'];
            $detalle->profundidad=$value['profundidad'];
            $detalle->origen=$value['origen'];
            $detalle->destino=$value['destino'];
            $detalle->inspection_id=$inspection->id;
            $detalle->orden=$value['orden'];
            $detalle->save();

        }

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        return Camara::where('id',$id)->with('inspection')->first();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Camara $camara)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCamaraRequest $request, Camara $camara)
    {
                //validar datos
        $request->validate([
            'lng' => 'required|numeric',
            'lat' => 'required|numeric',
            'elevacion' => 'required|numeric',
            'ubicacion' => 'required|string|max:255',
            'altura' => 'nullable|numeric',
            'tipo' => 'nullable|string|max:255',
        ]);
        // verificar codigo tenga dato y no se repita sin contar el mismo registro
        if (empty($request->codigo)) {
            return response()->json(['error' => 'El código es requerido'], 422);
        }
        $existingCamara = Camara::where('codigo', strtoupper($request->codigo))
            ->where('id', '!=', $camara->id)
            ->first();
        if ($existingCamara) {
            return response()->json(['error' => 'El código ya existe'], 422);
        }

        $camara = Camara::find($request->id);
        $camara->lng=$request->lng;
        $camara->lat=$request->lat;
        $camara->elevacion=$request->elevacion;
        $camara->ubicacion=$request->ubicacion;
        $camara->codigo=strtoupper($request->codigo);
        $camara->altura=$request->altura;
        $camara->tipo=$request->tipo;
        $camara->rasante=strtoupper($request->rasante);
        $camara->material=strtoupper($request->material);
        $camara->diametro=$request->diametro;
        $camara->altapa=$request->altapa;
        $camara->tiptapa=$request->tiptapa;
        $camara->save();

        DB::SELECT("UPDATE camaras 
                SET geom = ST_Transform(
                            ST_SetSRID(ST_MakePoint(lng, lat), 4326), 
                            32719
                        )
                WHERE id = $camara->id;");

        $inspec=$request->inspec;
        $inspection = Inspection::find($inspec['id']);
        $inspection->estadotapa=isset($inspec['estadotapa'])?$inspec['estadotapa']:null;
        $inspection->apertura=isset($inspec['apertura'])?$inspec['apertura']:null;
        $inspection->drenaje=isset($inspec['drenaje'])?$inspec['drenaje']:null;
        $inspection->estadoci=isset($inspec['estadoci'])?$inspec['estadoci']:null;
        $inspection->aro=isset($inspec['aro'])?$inspec['aro']:null;
        $inspection->paredes=isset($inspec['paredes'])?$inspec['paredes']:null;
        $inspection->solera=isset($inspec['solera'])?$inspec['solera']:null;
        $inspection->condicion=isset($inspec['condicion'])?$inspec['condicion']:null;
        $inspection->sedimento=isset($inspec['sedimento'])?$inspec['sedimento']:null;
        $inspection->alturasedi=isset($inspec['alturasedi'])?$inspec['alturasedi']:null;
        $inspection->estadosol=isset($inspec['estadosol'])?$inspec['estadosol']:null;
        $inspection->escalon=isset($inspec['escalon'])?$inspec['escalon']:null;
        $inspection->estadofis=isset($inspec['estadofis'])?$inspec['estadofis']:null;
        $inspection->observacion=isset($inspec['observacion'])?$inspec['observacion']:null;
        $inspection->save();
    }

    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Camara $camara)
    {
        //
    }

    public function listMaterial(){
        return DB::SELECT("SELECT distinct(material) from camaras");
    }

    public function listRasante(){
        return DB::SELECT("SELECT distinct(rasante) from camaras");
    }

    public function reporte(){
        $apertura=DB::SELECT("SELECT apertura, count(*) total from inspections i group by apertura  ");
        $tcamara=DB::SELECT("SELECT tipo, count(*) total from camaras c group by tipo ");
        $ttapa=DB::SELECT("SELECT tiptapa , count(*) total from camaras c group by tiptapa ");
        $rasante=DB::SELECT("SELECT rasante , count(*) total from camaras c group by rasante ");
        $matrasante=DB::SELECT("SELECT material , count(*) total from camaras c group by material ");
        $estapa=DB::SELECT("SELECT estadotapa , count(*) total from inspections i group by estadotapa ");
        $estadoci=DB::SELECT("SELECT estadoci , count(*) total from inspections i group by estadoci");
        $condicion=DB::SELECT("SELECT condicion , count(*) total from inspections i group by condicion ");        
        $defectos= DB::SELECT("	select 'aro' defecto , count(*) total from inspections i where aro=true union
            select 'paredes' defecto , count(*) total from inspections i where paredes =true union
            select 'solera' defecto , count(*) total from inspections i where solera =true ");
        $solera=DB::SELECT("SELECT estadosol , count(*) total from inspections i group by estadosol");
        $escalones=DB::SELECT("SELECT escalon , count(*) total from inspections i group by escalon");
        $fisico=DB::SELECT("	select 'PERDIDO' fisico , count(*) total from inspections i where estadofis like '%PERDIDO%' union
            select 'REALIZAR POZO' fisico , count(*) total from inspections i where estadofis like '%REALIZAR POZO%' union	
            select 'ENCIMA DE RASANTE' fisico , count(*) total from inspections i where estadofis like '%ENCIMA DE RASANTE%' union
            select 'RELLENO LATERAL' fisico , count(*) total from inspections i where estadofis like '%RELLENO LATERAL%' ");
       $tubmaterial=DB::SELECT("SELECT material , count(*) total from detalles d group by material ");
       $tubdiametro=DB::SELECT("SELECT diametro , count(*) total from detalles d group by diametro ");

       $consultas = [
        [
            'titulo' => 'Posibilidad de apertura',
            'datos' => $apertura,
            'columnas' => ['apertura', 'total']  // Cambia estas columnas a las que corresponden
        ],
        [
            'titulo' => 'tipos de CI',
            'datos' => $tcamara,
            'columnas' => ['tipo', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'tipo de tapa',
            'datos' => $ttapa,
            'columnas' => ['tiptapa', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'tipo de razante',
            'datos' => $rasante,
            'columnas' => ['rasante', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'Material razante',
            'datos' => $matrasante,
            'columnas' => ['material', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'estado de tapa',
            'datos' => $estapa,
            'columnas' => ['estadotapa', 'total']  // Cambia estas columnas a las que corresponden
        ],    
        [
            'titulo' => 'estado de cámara',
            'datos' => $estadoci,
            'columnas' => ['estadoci', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'condición de cámara',
            'datos' => $condicion,
            'columnas' => ['condicion', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'localización de defectos',
            'datos' => $defectos,
            'columnas' => ['defecto', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'estado solerá',
            'datos' => $solera,
            'columnas' => ['estadosol', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'estado de escalones',
            'datos' => $escalones,
            'columnas' => ['escalon', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'estado físico CI',
            'datos' => $fisico,
            'columnas' => ['fisico', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'material de tubería',
            'datos' => $tubmaterial,
            'columnas' => ['material', 'total']  // Cambia estas columnas a las que corresponden
        ],        
        [
            'titulo' => 'diámetros de tubos',
            'datos' => $tubdiametro,
            'columnas' => ['diametro', 'total']  // Cambia estas columnas a las que corresponden
        ],

    ];

    // Generar el PDF con la vista y los datos
    $pdf = Pdf::loadView('mi_pdf', compact('consultas'));
    return $pdf->download('reporte.pdf');
        
    }


}
