<template>
    <q-page class="q-pa-xs">
    <div class="text-bold text-h5 text-center">LISTADO DE REGISTRO</div> 
    <q-table
        :rows="camaras"
        :columns="columns"
        :filter="filter"
        row-key="name"
        dense
    >
    <template v-slot:top-right>
                <q-btn color="green" icon="check" label="REGISTRAR" @click="dialogReg=true" v-if="store.boolreg"/>
                <q-input borderless dense debounce="300" v-model="filter" placeholder="Search">
                <template v-slot:append>
                    <q-icon name="search" />
                </template>
                </q-input>
            </template>
            <template v-slot:body-cell-op="props">
                <q-td key="op" :props="props">
                    <q-btn flat size="sm" color="cyan" icon="format_list_bulleted"  @click="getFormulario1(props.row)" v-if="store.boolmodtub">
                        <q-tooltip >
                            MODIFICAR DATOS CAMARA ESTADO
                        </q-tooltip>
                    </q-btn>
                    <q-btn flat size="sm" color="yellow" icon="edit"  @click="getFormulario2(props.row)" v-if="store.boolmodat">
                    <q-tooltip >
                        MODIFICAR DATOS TUBERIAS
                        </q-tooltip>
                    </q-btn>
                    <q-btn flat size="sm" color="info" icon="print"  @click="impresion(props.row)" >
                        <q-tooltip >
                            IMPRESION DE FORMULARIO
                        </q-tooltip>
                    </q-btn>
                </q-td>
            </template>
    </q-table>
    <q-dialog v-model="dialogReg" persistent full-width>
        <q-card>
            <q-card-section class="row items-center">
                <q-avatar size="sm" icon="signal_wifi_off" color="primary" text-color="white" />
                <span class="q-ml-sm">REGISTRAR INSPECCION</span>
            </q-card-section>

                <q-form
                    @submit.prevent="registrar"
                    class="q-gutter-md"
                >
                <q-card-section>
                <q-tabs
                    v-model="tab"
                    class="bg-purple text-white"
                    align="justify"
                    narrow-indicator
                    >
                    <q-tab name="INFO" label="INFO" />
                    <q-tab name="CONT" label="CONT" />
                    <q-tab name="DESCRIB" label="DESCRIB" />
                    <q-tab name="TUBERIA" label="TUBERIA" v-if="camara.id==undefined"/>
                </q-tabs> 

                <q-tab-panels v-model="tab" animated    >
                    <q-tab-panel name="INFO">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 q-pa-xs"><q-input v-model="inspec.fecha" type="date"  label="Fecha *" dense outlined readonly/></div>
                            <div class="col-md-6 col-xs-12 q-pa-xs"><q-input v-model="camara.codigo" type="text" label="Codigo Camara *" dense outlined required/></div>
                            <div class="col-md-4 col-xs-12 q-pa-xs"><q-input v-model="camara.lng" type="number" step="0.0000000001" label="Longitud/ESTE *" dense outlined required/></div>
                            <div class="col-md-4 col-xs-12 q-pa-xs"><q-input v-model="camara.lat" type="number" step="0.0000000001" label="Latitud/NORTE *" dense outlined required/></div>
                            <div class="col-md-4 col-xs-12 q-pa-xs"><q-input v-model="camara.elevacion" type="number" step="0.01" label="Elevacion *" dense outlined required/></div>
                            <div class="col-md-12 col-xs-12 q-pa-xs"><q-input v-model="camara.ubicacion"  label="Ubicacion *" dense outlined required/></div>
                            <div class="col-md-12 col-xs-12 q-pa-xs"><q-toggle v-model="inspec.apertura" color="green" :label="inspec.apertura +'Apertura *' " dense false-value="NO" true-value="SI" required/></div>                    
                        </div>                        
                    </q-tab-panel>
                    <q-tab-panel name="CONT">
                        <div class="row">
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-input v-model="camara.altura" type="number" step="0.01" label="Altura Solera Cota (m) *" dense outlined/></div>
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="camara.tipo" :options="['CON CONO','SIN CONO','CAJA']" label="Tipo C.I." dense outlined/></div>
                    <div class="col-md-4 col-xs-12 q-pa-xs"><q-input v-model="camara.altapa" type="number" step="0.01" label="Altura Tapa (m)" dense outlined/></div>
                    <div class="col-md-4 col-xs-12 q-pa-xs"><q-select v-model="camara.diametro" :options="diametros2" label="Diametro Tapa (m)" dense outlined/></div>
                    <div class="col-md-4 col-xs-12 q-pa-xs"><q-select v-model="camara.tiptapa" :options="['HIERRO','CONCRETO','SIN TAPA']" label="Tipo Tapa *" dense outlined/></div>
                    <div class="col-md-6 col-xs-12  q-pa-xs"><q-input v-model="camara.rasante"  label="Rasante *"  style="text-transform: uppercase;" dense list="rasantes" outlined/>
                       <datalist id="rasantes">
                         <option v-for="r in rasantes" :key="r.rasante">{{r.rasante}}</option>
                      </datalist>
                    </div>
                        <div class="col-md-6 col-xs-12  q-pa-xs"><q-input v-model="camara.material" label="Material Rasante *" dense list="materiales" style="text-transform: uppercase;" outlined/>
                            <datalist id="materiales">
                            <option v-for="r in materiales" :key="r.material">{{r.material}}</option>
                        </datalist>
                        </div>                    
                    </div>
                    </q-tab-panel>
                    <q-tab-panel name="DESCRIB">
                        <div class="row">
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="inspec.estadotapa" :options="['BUENA','REGULAR','MALO']" label="Estado de Tapa *" dense outlined/></div>
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="inspec.drenaje" :options="['BUENO','REGULAR','MALO']" label="Drenaje" dense outlined /></div>
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="inspec.estadoci" :options="['BUENO','REGULAR','MALO']" label="Estado Camara " dense outlined/></div>
                    <div class="col-md-6 col-xs-12 q-pa-xs" >
                        <label for="" class="text-h6">Localizacion de Defectos</label><br>
                        <q-toggle class="q-pa-xs" v-model="inspec.aro"  label="ARO" color="teal" dense/>
                        <q-toggle class="q-pa-xs" v-model="inspec.paredes"  label="PAREDES" color="teal" dense/>
                        <q-toggle class="q-pa-xs" v-model="inspec.solera"  label="SOLERA" color="teal" dense />
                    </div>
                    <div class="col-md-4 col-xs-12 q-pa-xs"><q-select v-model="inspec.condicion" :options="['LIMPIO','OBSTRUIDO','SEDIMENTO','COLMATADO']" label="Condicion de Camara" dense outlined/></div>
                    <div class="col-md-8 col-xs-12 q-pa-xs" style="font-size: 10px;">
                        <label for="" class="text-h6">Tipo de Sedimento</label><br>
                        <q-checkbox class="q-pa-xs" v-model="selection2" val="PIEDRA" label="PIEDRA" color="teal" dense/>
                        <q-checkbox class="q-pa-xs" v-model="selection2" val="LODO" label="LODO" color="teal" dense/>
                        <q-checkbox class="q-pa-xs" v-model="selection2" val="ARENA" label="ARENA" color="teal" dense />
                        <q-checkbox class="q-pa-xs" v-model="selection2" val="BASURA" label="BASURA" color="teal" dense />
                    </div>
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-input v-model="inspec.alturasedi"  label="Altura Sedimento (m)" type="number" step="0.01" dense outlined/></div>
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="inspec.estadosol" :options="['BUENA','REGULAR','MALO','NO TIENE']" label="Estado Solera" dense outlined/></div>
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="inspec.escalon" :options="['BUENA','REGULAR','MALO','NO TIENE']" label="Estado Escalon" dense outlined/></div>
                    <div class="col-md-12 col-xs-12 q-pa-xs" style="font-size: 10px;">
                        <label for="" class="text-h6">Estado Fisico C.I.</label><br>
                        <q-checkbox class="q-pa-xs" v-model="selection3" val="PERDIDO" label="PERDIDO" color="teal" dense/>
                        <q-checkbox class="q-pa-xs" v-model="selection3" val="REALIZAR POZO" label="REALIZAR POZO" color="teal" dense/>
                        <q-checkbox class="q-pa-xs" v-model="selection3" val="ENCIMA DE RASANTE" label="ENCIMA DE RASANTE" color="teal" dense />
                        <q-checkbox class="q-pa-xs" v-model="selection3" val="RELLENO LATERAL" label="RELLENO LATERAL" color="teal" dense />
                    </div>
                    <div class="col-md-12 col-xs-12 q-pa-xs"><q-input v-model="inspec.observacion" type="textarea" label="Observacion *" dense outlined/></div>

                </div>
                    </q-tab-panel>
                    <q-tab-panel name="TUBERIA">
                        <div class="row">
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="dato.tipo"  label="Tipo *" :options="['SANITARIO','PLUVIAL']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.codigo"  label="Codigo" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.gestion"  label="Gestion" type="number" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="dato.diametro" :options="diametros1"  label="Diametro (plg)*"  dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="dato.material"  label="Material *" :options="['PVC','HORMIGON']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.profundidad"  label="Profundidad *" type="number" step="0.01" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.origen"  label="Origen *" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.destino"  label="Destino *" dense outlined/></div>
                    <div class="col-md-1 col-xs-6 q-pa-xs"><q-btn color="green" icon="add"  @click="agregar" /></div>
                </div>
                <q-table
                title="Lista Tuberias"
                :rows="detalle"
                    :columns="coldetalle"
                    row-key="name"
                    dense
                    >
                    <template v-slot:body-cell-op="props">
                    <q-td key="op" :props="props">
                        <q-btn flat size="sm" color="red" icon="delete"  @click="retirar(props)" />
                    </q-td>
                </template>
                </q-table>
                    </q-tab-panel>

                </q-tab-panels>

            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="Cancelar" color="red" v-close-popup />
                <q-btn flat label="Registrar" type="submit" color="green" v-if="camara.id==undefined"/>
                <q-btn flat label="Modificar" type="submit" color="yellow" v-else/>
            </q-card-actions>
            </q-form>
        </q-card>
    </q-dialog>

    <q-dialog v-model="dialogDetalle" persistent full-width>
        <q-card>
            <q-card-section class="row items-center">
                <q-avatar size="sm" icon="signal_wifi_off" color="primary" text-color="white" />
                <span class="q-ml-sm">MODIFICAR DATOS DE TUBERIAS C.I. {{ camara.codigo }}</span>
            </q-card-section>
            <q-card-section>
                <div class="row">
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="dato.tipo"  label="Tipo *" :options="['SANITARIO','PLUVIAL']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.codigo"  label="Codigo" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.gestion"  label="Gestion" type="number" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="dato.diametro" :options="diametros1"  label="Diametro (plg)*"  dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="dato.material"  label="Material *" :options="['PVC','HORMIGON']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.profundidad"  label="Profundidad *" type="number" step="0.01" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.origen"  label="Origen *" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.destino"  label="Destino *" dense outlined/></div>
                    <div class="col-md-2 col-xs-6 q-pa-xs"><q-btn color="green" icon="add" label="Registrar" @click="registrarDetalle" /></div>
                </div>
                <q-table
                    title="Lista Tuberias"
                    :rows="listDetalle"
                    :columns="coldetalle"
                    row-key="name"
                    dense
                >
                <template v-slot:body-cell-op="props">
                    <q-td key="op" :props="props">
                        <q-btn flat size="sm" color="red" icon="delete"  @click="delDetalle(props.row)" />
                    </q-td>
                </template>
                </q-table>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="Cancelar" color="red" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>
    <div id="myelement" class="hidden"></div>
    
    </q-page>
</template>
<script>
  import { date } from 'quasar'
  import { Printd } from 'printd'
  import { globalStore } from '../stores/globalStore'

  export default {
    name:'inspecionPage',
    data() {
        return {
            store: globalStore(),
            map:null,
            formulario:{},
            dialogReg:false,
            dialogDetalle:false,
            listDetalle:[],
            materiales:[],
            rasantes:[],
            camaras:[],
            filter:'',
            dato:{},
            detalle:[],
            selection:[],
            selection2:[],
            selection3:[],
            diametros1:[],
            diametros2:[],
            camara:{},
            listado:[],
            inspec:{apertura:'NO',fecha:date.formatDate(new Date(), 'YYYY-MM-DD'),aro:false,paredes:false,solera:false},
            tab:'INFO',
            columns:[
                {label:'OP',name:'op',field:'op'},
                {label:'CODIGO',name:'codigo',field:'codigo'},
                {label:'LNG',name:'lng',field:'lng'},
                {label:'LAT',name:'lat',field:'lat'},
                {label:'UBICACION',name:'ubicacion',field:'ubicacion'},
                {label:'FECHA',name:'fecha',field:'fecha'},
            ],
            coldetalle:[
                {label:'OP',name:'op',field:'op'},
                {label:'TIPO',name:'tipo',field:'tipo'},
                {label:'CODIGO',name:'codigo',field:'codigo'},
                {label:'GESTION',name:'gestion',field:'gestion'},
                {label:'DIAMETRO',name:'diametro',field:'diametro'},
                {label:'MATERIAL',name:'material',field:'material'},
                {label:'PROFUNDIDAD',name:'profundidad',field:'profundidad'},
                {label:'ORIGEN',name:'origen',field:'origen'},
                {label:'DESTINO',name:'destino',field:'destino'},
            ]
        }
    },
    created(){
        this.getDiam1()
        this.getDiam2()
        this.getCamara()
        this.getRasante()
        this.getMaterial()

    },
    methods:{
        mapSrc(lat,lng){
            return `/map?lat=${lat}&lon=${lng}`
        },
        getFormulario1(pr){
            this.$api.get('camara/'+pr.id).then((res) => {
                this.camara=res.data
                this.listDetalle=res.data.inspection.detalles
                this.dialogDetalle=true
            })
        },
        getFormulario2(pr){
            this.$api.get('camara/'+pr.id).then((res) => {
                this.camara=res.data
                this.inspec=res.data.inspection
                this.dialogReg=true
            })
        },
        impresion(prop){
            let dato=prop
            
            this.$api.get('camara/'+prop.id).then((res) => {
                let pr=res.data

            let detalle=pr.inspection.detalles
            let insp=pr.inspection
            let defecto=insp.aro==true?'ARO':''+' '+insp.paredes==true?'PAREDES':''+' '+insp.solera==true?'SOLERA':''
            if(insp.estadotapa==null) insp.estadotapa=''
            if(insp.condicion==null) insp.condicion=''
            if(insp.sedimento==null) insp.sedimento=''
            if(insp.alturasedi==null) insp.alturasedi=''
            if(insp.estadosol==null) insp.estadosol=''
            if(insp.escalon==null) insp.escalon=''
            if(insp.estadofis==null) insp.estadofis=''
            if(detalle.length==0)
                return false
            let contenido=''
            let num=1
            let ingreso=detalle[0].diametro
            let salida=detalle[1].diametro
            detalle.forEach(r => {
                if(r.codigo==null) r.codigo=''
                if(r.gestion==null) r.gestion=''
                contenido+='<tr><td>'+num+'</td><td>'+r.tipo+'</td><td>'+r.codigo+'</td><td>'+r.gestion+'</td><td>'+r.diametro+'</td><td>'+r.material+'</td><td>'+r.profundidad+'</td><td>'+r.origen+'</td><td>'+r.destino+'</td></tr>'
                num++
            });    
         
            //let mapImage = LocalStorage.getItem('mapImage');
            let cadena=`<html><head>
            <style>
            .tab1{
                width:100%;
                font-size:16px;
                border-collapse: collapse;
                text-align:center;
            }
            .tab1 td{
                border: 1px solid;  
            }
            .tab2{
                width:100%;
                font-size:14px;
                border-collapse: collapse;
            }
            .tab2 th{
                height:30px;
                border: 1px solid;  
                width:15%;
            }
            .tab2 td{
                border: 1px solid;  
                text-align:center;
                width:15%;
                max-width:20%;
            }
            .tab3{
                width:100%;
                font-size:12px;
                border-collapse: collapse;
            }
                .tab3 td{
                text-align:center;
                border: 1px solid;  
                }
            .tab3 th{
                border: 1px solid;  
                text-align:center;
                }
                        .tab4{
                width:100%;
                font-size:12px;
                border-collapse: collapse;
            }
                .tab4 td{
                text-align:left;
                border: 1px solid;  
                }
                .img1{width:100px;height:100px; text-align:center;}

        .leaflet-control-attribution {
            display: none; /* Oculta el nombre de Leaflet en el pie del mapa */
        }
            </style>
            </head>
            <body>
            <table class='tab1'>
                <tr><td style='width:15%'><img src='escudo.jpg' class='img1'></td>
                    <td>CATASTRO DE LA RED DE ALCANTARILLADO SANITARIO<br>GOBIERNO AUTÓNOMO MUNICIPAL DE ORURO<br>UNIDAD DE DRENAJE URBANO</td>
                    <td style='width:15%'><img src='udu.jpeg' class='img1'></td></tr>
            </table>
            <table class='tab1'>
                <tr><td>CROQUIS</td><td>Nro C.I. :`+pr.codigo+` </td></tr>
                <tr><td  style='width:50%; height:300px; text-align:right; vertical-align:top;padding:5px'><img src='norte.jpg' width='20px'> </td>
                <td style='width:50%'><div style='position: relative'><span style='position: absolute;top:80px; left:170px;'>`+pr.altura+' m</span> <span style="position: absolute;top:160px; left:60px;">'+ingreso+' "</span> <span style="position: absolute;top:160px; right:60px;">'+salida+` "</span>
                    <img src='camara.png' style='height:300px;'></div></td></tr>
             </table>
             <table class='tab2'>
                <tr><th colspan=4>INFORMACION DE LA TAPA</th></tr>
                <tr><th>Diametro de Tapa: </th><td>`+pr.diametro+'</td><th>Altura de Tapa: </th><td>'+pr.altapa+`</td></tr>
                <tr><th colspan=4>INFORMACION DE UBICACION</th></tr>
                <tr><th>Rasante: </th><td>`+pr.rasante+'</td><th>Material Rasante: </th><td>'+pr.material+`</td></tr>
             </table>
             <table class='tab2'>
                <tr><th>Ubicacion: </th><td colspan=5>`+pr.ubicacion+`</td></tr>
                <tr><th>Longitud (X): </th><td>`+pr.lng+'</td><th>Latitud (Y): </th><td>'+pr.lat+'</td><th>Elevacion (Z): </th><td>'+pr.elevacion+`</td></tr>
                <tr><th colspan=6>TUBERIAS EN C.I.</th></tr>
            </table>
            <table class='tab3'>
                <tr><th>No</th><th>TIPO</th><th>CODIGO</th><th>GESTION</th><th>DIAMETRO</th><th>MATERIAL</th><th>PROFUNDIDAD</th><th>ORIGEN</th><th>DESTINO</th></tr>
                `+contenido+`
            </table>
            <table class='tab3'><tr><th>Nro C.I. : `+pr.codigo+'</th><th>CARACTERISTICAS DEL POZO</th><th>FECHA: ' +pr.inspection.fecha+`</th></tr></table>
            <table class='tab4' style='text-align:left'>
                <tr>
                    <td>
                    <b>Tipo de tapa Estado : </b>`+insp.estadotapa+`<br>
                    <b>Posibilidad de apertura : </b>`+insp.apertura+`<br>
                    <b>Tipo de C.I.  : </b>`+pr.tipo+`<br>
                    <b>Drenaje  : </b>`+insp.drenaje+`<br>
                    <b>Estado de C.I. : </b>`+insp.estadoci+`<br>
                    <b>Localizacion de Defectos : </b>`+defecto+`<br>
                    </td>
                    <td>
                    <b>Condicion de C.I. : </b>`+insp.condicion+`<br>
                    <b>Tipo de Sedimento : </b>`+insp.sedimento+`<br>
                    <b>Altura del Sedimento : </b>`+insp.alturasedi+`<br>
                    <b>Estado de la Solera : </b>`+insp.estadosol+`<br>
                    <b>Condicion de Escalones : </b>`+insp.escalon+`<br>
                    <b>Estado Físico de C.I. : </b>`+insp.estadofis+`<br>
                    </td>
                </tr>
                <tr><td colspan=2><b>Observacion</b><br>`+insp.observacion+`<br></td></tr>
            </table>
            <table class='tab4'>
                <tr><td style='height:50px'>Elaborado Por: </td><td>Revisado Por</td><td>Actualizado por:</td></tr>
            </table>
            </body>
            </html>
            `
            document.getElementById('myelement').innerHTML = cadena
            const d = new Printd()
            d.print( document.getElementById('myelement') ) 
        })

        },
        delDetalle(dt){
            this.$api.delete('detalle/'+dt.id).then(() => {
                this.getDetalle(this.camara)
            })
            
        },
        getDetalle(pr){
            this.$api.get('detalle/'+pr.inspection.id).then((res) => {
                this.listDetalle=res.data
            })

        },
        retirar(props){
            this.detalle.splice(props.rowIndex,1);
        },
        onReset(){
            this.inspec={apertura:'NO',fecha:date.formatDate(new Date(), 'YYYY-MM-DD'),aro:false,paredes:false,solera:false}
            this.camara={}
            this.selection=[]
            this.selection2=[]
            this.selection3=[]
            this.detalle=[]
        },
        getRasante(){
        this.$api.get('listMaterial').then((res) => {
            console.log(res.data)
                this.materiales=res.data
            })
        },
        getMaterial(){
        this.$api.get('listRasante').then((res) => {
            console.log(res.data)
                this.rasantes=res.data
            })
        },
        getCamara(){
            this.$api.get('camara').then((res) => {
                console.log(res.data)
                this.camaras=res.data
            })

        },
        getDiam1(){
        this.$api.get('listDiamts').then((res) => {
            this.diametros1
            res.data.forEach(r => {
                this.diametros1.push(r.medida)
            });
            })
        },
        getDiam2(){
        this.$api.get('listDiamplg').then((res) => {
            this.diametros2
            res.data.forEach(r => {
                this.diametros2.push(r.medida)
            });
            })
        },
        agregar(){
            if(this.dato.tipo==undefined || this.dato.diametro==undefined || this.dato.material==undefined || this.dato.profundidad==undefined || this.dato.origen==undefined || this.dato.destino==undefined){
                return false
            }
            if(this.dato.codigo==undefined) this.dato.codigo=''
            if(this.dato.gestion==undefined) this.dato.gestion=''
            this.detalle.push(this.dato)
            this.dato={}
        },  
        registrarDetalle(){
            if(this.dato.tipo==undefined || 
               this.dato.diametro==undefined || 
               this.dato.material==undefined || 
               this.dato.profundidad==undefined || 
               this.dato.origen==undefined || 
               this.dato.destino==undefined){
                return false
            }

            if(this.dato.codigo==undefined) this.dato.codigo=''
            if(this.dato.gestion==undefined) this.dato.gestion=''
            this.dato.inspection_id=this.camara.inspection.id
            this.$api.post('detalle',this.dato).then(() => {
                this.dato={}
                this.getDetalle(this.camara)
            })
        },  
        registrar(){
            let cad=''
            let cad2=''

            this.selection2.forEach(r => {
                cad+=r+ ', '
            });
            this.selection3.forEach(r => {
                cad2+=r+ ', '
            });

            this.inspec.sedimento=cad
            this.inspec.estadofis=cad2
            this.camara.inspec=this.inspec

            if(this.camara.id==undefined){
            if(this.detalle.length==0)
                {
                    this.$q.notify({
                    message: 'DEBE Registrar Tuberia',
                    color: 'negative',
                    position: 'top',
                    icon:'info'
                    }) 
                    return false
                }

            this.camara.detalle=this.detalle
            
            this.$api.post('camara',this.camara).then((res) => {
                console.log(res.data)
                this.dialogReg=false
                this.onReset()
                this.getMaterial()
                this.getRasante()
                this.getCamara()
            });
            }
            else{
            
                this.$api.put('camara/'+this.camara.id,this.camara).then((res) => {
                console.log(res.data)
                this.dialogReg=false
                this.onReset()
                this.getMaterial()
                this.getRasante()
                this.getCamara()
            });
            }

        },

    }
}
</script>
