<template>
    <q-page class="q-pa-xs">
    <div class="text-bold text-h5 text-center">LISTADO DE INSPECCION RED PLUVIAL</div> 
    <q-table
        :rows="sewers"
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
                    <q-btn flat size="sm" color="cyan" icon="format_list_bulleted"  @click="modificar(props.row)" v-if="store.boolmodtub">
                        <q-tooltip >
                            MODIFICAR DATOS 
                        </q-tooltip>
                    </q-btn>
                    <q-btn flat size="sm" color="purple" icon="show_chart"  @click="getFormulario1(props.row)" v-if="store.boolmodat">
                        <q-tooltip >
                            MODIFICAR DATOS TUBERIAS
                        </q-tooltip>
                    </q-btn>
                    <q-btn flat size="sm" color="cyan" icon="cyclone"  @click="getFormulario2(props.row)" v-if="store.boolmodat">
                        <q-tooltip >
                            MODIFICAR DATOS SUMIDERO
                        </q-tooltip>
                    </q-btn>
                    <q-btn flat size="sm" color="yellow" icon="device_hub"  @click="getFormulario3(props.row)" v-if="store.boolmodat">
                        <q-tooltip >
                            MODIFICAR DATOS TUB SUMIDERO
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
                <span class="q-ml-sm">REGISTRAR DATOS PLUVIAL</span>
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
                </q-tabs> 

                <q-tab-panels v-model="tab" animated    >
                    <q-tab-panel name="INFO">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 q-pa-xs"><q-input v-model="sewer.fecha" type="date"  label="Fecha *" dense outlined readonly/></div>
                            <div class="col-md-6 col-xs-12 q-pa-xs"><q-input v-model="sewer.codigo" type="text" label="Codigo Camara *" dense outlined required/></div>
                            <div class="col-md-4 col-xs-12 q-pa-xs"><q-input v-model="sewer.lng" type="number" step="0.0000000001" label="Longitud/ESTE *" dense outlined required/></div>
                            <div class="col-md-4 col-xs-12 q-pa-xs"><q-input v-model="sewer.lat" type="number" step="0.0000000001" label="Latitud/NORTE *" dense outlined required/></div>
                            <div class="col-md-4 col-xs-12 q-pa-xs"><q-input v-model="sewer.elevacion" type="number" step="0.01" label="Elevacion *" dense outlined required/></div>
                            <div class="col-md-12 col-xs-12 q-pa-xs"><q-input v-model="sewer.ubicacion"  label="Ubicacion *" dense outlined required/></div>
                            <div class="col-md-12 col-xs-12 q-pa-xs"><q-toggle v-model="sewer.apertura" color="green" :label="sewer.apertura +'Apertura *' " dense false-value="NO" true-value="SI" required/></div>                    
                        </div>                        
                    </q-tab-panel>
                    <q-tab-panel name="CONT">
                        <div class="row">
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-input v-model="sewer.altura" type="number" step="0.01" label="Altura Solera Cota (m) *" dense outlined/></div>
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="sewer.tipo" :options="['CON CONO','SIN CONO','CAJA']" label="Tipo C.I." dense outlined/></div>
                    <div class="col-md-4 col-xs-12 q-pa-xs"><q-input v-model="sewer.altapa" type="number" step="0.01" label="Altura Tapa (m)" dense outlined/></div>
                    <div class="col-md-4 col-xs-12 q-pa-xs"><q-select v-model="sewer.diametro" :options="diametros" label="Diametro Tapa (m)" dense outlined/></div>
                    <div class="col-md-4 col-xs-12 q-pa-xs"><q-select v-model="sewer.tiptapa" :options="['HIERRO','CONCRETO','SIN TAPA']" label="Tipo Tapa *" dense outlined/></div>
                    <div class="col-md-6 col-xs-12  q-pa-xs"><q-input v-model="sewer.rasante"  label="Rasante *"  style="text-transform: uppercase;" dense list="rasantes" outlined/>
                       <datalist id="rasantes">
                         <option v-for="r in rasantes" :key="r.rasante">{{r.rasante}}</option>
                      </datalist>
                    </div>
                        <div class="col-md-6 col-xs-12  q-pa-xs"><q-input v-model="sewer.material" label="Material Rasante *" dense list="materiales" style="text-transform: uppercase;" outlined/>
                            <datalist id="materiales">
                            <option v-for="r in materiales" :key="r.material">{{r.material}}</option>
                        </datalist>
                        </div>                    
                    </div>
                    </q-tab-panel>
                    <q-tab-panel name="DESCRIB">
                        <div class="row">
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="sewer.estado" :options="['BUENA','REGULAR','MALO']" label="Estado de Tapa *" dense outlined/></div>
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="sewer.drenaje" :options="['BUENO','REGULAR','MALO']" label="Drenaje" dense outlined /></div>
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="sewer.estadoci" :options="['BUENO','REGULAR','MALO']" label="Estado Camara " dense outlined/></div>
                    <div class="col-md-6 col-xs-12 q-pa-xs" >
                        <label for="" class="text-h6">Localizacion de Defectos</label><br>
                        <q-toggle class="q-pa-xs" v-model="sewer.aro"  label="ARO" color="teal" dense/>
                        <q-toggle class="q-pa-xs" v-model="sewer.paredes"  label="PAREDES" color="teal" dense/>
                        <q-toggle class="q-pa-xs" v-model="sewer.solera"  label="SOLERA" color="teal" dense />
                    </div>
                    <div class="col-md-4 col-xs-12 q-pa-xs"><q-select v-model="sewer.condicion" :options="['LIMPIO','OBSTRUIDO','SEDIMENTO','COLMATADO']" label="Condicion de Camara" dense outlined/></div>
                    <div class="col-md-8 col-xs-12 q-pa-xs" style="font-size: 10px;">
                        <label for="" class="text-h6">Tipo de Sedimento</label><br>
                        <q-checkbox class="q-pa-xs" v-model="selection2" val="PIEDRA" label="PIEDRA" color="teal" dense/>
                        <q-checkbox class="q-pa-xs" v-model="selection2" val="LODO" label="LODO" color="teal" dense/>
                        <q-checkbox class="q-pa-xs" v-model="selection2" val="ARENA" label="ARENA" color="teal" dense />
                        <q-checkbox class="q-pa-xs" v-model="selection2" val="BASURA" label="BASURA" color="teal" dense />
                    </div>
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="sewer.escalon" :options="['SI','NO']" label="Estado Escalon" dense outlined/></div>

                    <div class="col-md-12 col-xs-12 q-pa-xs"><q-input v-model="sewer.observacion" type="textarea" label="Observacion *" dense outlined/></div>

                </div>
                    </q-tab-panel>


                </q-tab-panels>

            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="Cancelar" color="red" v-close-popup />
                <q-btn flat label="Registrar" type="submit" color="green" v-if="sewer.id==undefined"/>
                <q-btn flat label="Modificar" type="submit" color="yellow" v-else/>
            </q-card-actions>
            </q-form>
        </q-card>
    </q-dialog>

    <q-dialog v-model="dialogDetalle" persistent full-width>
        <q-card>
            <q-card-section class="row items-center">
                <q-avatar size="sm" icon="signal_wifi_off" color="primary" text-color="white" />
                <span class="q-ml-sm">DATOS DE TUBERIAS C.I. {{ sewer.codigo }}</span>
            </q-card-section>
            <q-card-section>
                <div class="row">
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="dato.tipo"  label="Tipo *" :options="['SANITARIO','PLUVIAL']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="dato.funcion"  label="Funcionalidad" :options="['PLUVIAL','MIXTO']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="dato.gestion"  label="Gestion" type="number" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="dato.diametro" :options="diametros"  label="Diametro (mm)*"  dense outlined/></div>
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

    <q-dialog v-model="dialogSumidero" persistent full-width>
        <q-card>
            <q-card-section class="row items-center">
                <q-avatar size="sm" icon="signal_wifi_off" color="primary" text-color="white" />
                <span class="q-ml-sm">DATOS DE SUMIDEROS {{ sewer.codigo }}</span>
            </q-card-section>
            <q-card-section>
                <div class="row">
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="sumidero.material"  label="Material Rasante *" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="sumidero.tapa"  label="Tipo Tapa" :options="['HIERRO','CONCRETO','SIN TAPA']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="sumidero.estado"  label="Estado Tapa" :options="['BUENO','REGULAR','MALO']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="sumidero.apertura"  label="Apertura" :options="['SI','NO']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="sumidero.sedimento"  label="Tipo Sedimento" :options="['PIEDRA','LODO','ARENA','BASURA']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="sumidero.altsed"  label="Altura Sedimento" type="number" step="0.01" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="sumidero.condicion" :options="['LIMPIO','OBSTRUIDO','SEDIMENTO','COLMATADO']"  label="CONDICION"  dense outlined/></div>
                    <div class="col-md-2 col-xs-6 q-pa-xs"><q-btn color="green" icon="add" label="Registrar" @click="registrarSumidero" /></div>
                </div>
                <q-table
                    title="Lista Sumideros"
                    :rows="sumideros"
                    :columns="colSum"
                    row-key="name"
                    dense
                >
                <template v-slot:body-cell-op="props">
                    <q-td key="op" :props="props">
                        <q-btn flat size="sm" color="red" icon="delete"  @click="delSum(props.row)" />
                    </q-td>
                </template>
                </q-table>
            </q-card-section>
            <q-card-actions align="right">
                <q-btn flat label="Cancelar" color="red" v-close-popup />
            </q-card-actions>
        </q-card>
    </q-dialog>

    <q-dialog v-model="dialogConducto" persistent full-width>
        <q-card>
            <q-card-section class="row items-center">
                <q-avatar size="sm" icon="signal_wifi_off" color="primary" text-color="white" />
                <span class="q-ml-sm">DATOS DE TUBERIAS SUMIDEROS </span>
            </q-card-section>
            <q-card-section>
                <div class="row">
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="conducto.tipo"  label="Tipo" :options="['PLUVIAL','MIXTO']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="conducto.material"  label="Material" :options="['PVC','CONCRETOS']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="conducto.largo"  label="Largo Tapa *" type="number" step="0.01" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="conducto.ancho"  label="Largo Ancho *" type="number" step="0.01" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="conducto.alto"  label="Largo Alto *" type="number" step="0.01" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="conducto.diametro"  label="Diametro " :options="diametros" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="conducto.profundidad"  label="Profundidad *" type="number" step="0.01" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-select v-model="conducto.apertura"  label="Apertura" :options="['SI','NO']" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="conducto.origen"  label="Viene de" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="conducto.destino"  label="Va a " dense outlined/></div>
                    <div class="col-md-2 col-xs-6 q-pa-xs"><q-btn color="green" icon="add" label="Registrar" @click="registrarConducto" /></div>
                </div>
                <q-table
                    title="Lista Tuberias Sumideros"
                    :rows="conductos"
                    :columns="colConducto"
                    row-key="name"
                    dense
                >
                <template v-slot:body-cell-op="props">
                    <q-td key="op" :props="props">
                        <q-btn flat size="sm" color="red" icon="delete"  @click="delCond(props.row)" />
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
    name:'pluvialPage',
    data() {
        return {
            sumidero:{},
            store: globalStore(),
            map:null,
            formulario:{},
            dialogReg:false,
            dialogDetalle:false,
            dialogSumidero:false,
            dialogConducto:false,
            listDetalle:[],
            materiales:[],
            rasantes:[],
            sewers:[],
            filter:'',
            dato:{},
            detalle:[],
            selection:[],
            selection2:[],
            selection3:[],
            diametros:[],
            listado:[],
            sumideros:[],
            conductos:[],
            conducto:{},
            sewer:{apertura:'NO',fecha:date.formatDate(new Date(), 'YYYY-MM-DD'),aro:false,paredes:false,solera:false},
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
                {label:'FUNCIONALIDAD',name:'funcion',field:'funcion'},
                {label:'GESTION',name:'gestion',field:'gestion'},
                {label:'DIAMETRO',name:'diametro',field:'diametro'},
                {label:'MATERIAL',name:'material',field:'material'},
                {label:'PROFUNDIDAD',name:'profundidad',field:'profundidad'},
                {label:'ORIGEN',name:'origen',field:'origen'},
                {label:'DESTINO',name:'destino',field:'destino'},
            ],
            colSum:[
                {label:'OP',name:'op',field:'op'},
                {label:'MATERIAL',name:'material',field:'material'},
                {label:'TIP TAPA',name:'tapa',field:'tapa'},
                {label:'ESTADO',name:'estado',field:'estado'},
                {label:'APERTURA',name:'apertura',field:'apertura'},
                {label:'TIP SEDIMENTO',name:'sedimento',field:'sedimento'},
                {label:'ALT SEDIMENTO',name:'altsed',field:'altsed'},
                {label:'CONDICION CI',name:'condicion',field:'condicion'},
            ],
            colConducto:[
                {label:'OP',name:'op',field:'op'},
                {label:'TIPO',name:'tipo',field:'tipo'},
                {label:'MATERIAL',name:'material',field:'material'},
                {label:'LARGO',name:'largo',field:'largo'},
                {label:'ANCHO',name:'ancho',field:'ancho'},
                {label:'ALTO',name:'alto',field:'alto'},
                {label:'DIAMETRO',name:'diametro',field:'diametro'},
                {label:'PROFUNDIDAD',name:'profundidad',field:'profundidad'},
                {label:'ORIGEN',name:'origen',field:'origen'},
                {label:'DESTINO',name:'destino',field:'destino'},
            ]
        }
    },
    created(){
        this.getDiam3()
        this.getSewer()
        this.getRasante()
        this.getMaterial()

    },
    methods:{
        registrarConducto(){
            if(this.conducto.tipo==undefined || this.conducto.material==undefined || this.conducto.largo==undefined || this.conducto.ancho==undefined || this.conducto.alto==undefined
                || this.conducto.diametro==undefined || this.conducto.profundidad==undefined)
            return false
            this.conducto.sewer_id=this.sewer.id
            this.$api.post('conducto',this.conducto).then(() => {
                //console.log(res.data)
                this.conducto={}
                this.getFormulario3(this.sewer)
            })

        },
        registrarSumidero(){
            if(this.sumidero.material==undefined || this.sumidero.tapa==undefined || this.sumidero.estado==undefined || this.sumidero.apertura==undefined || this.sumidero.sedimento==undefined
                || this.sumidero.altsed==undefined || this.sumidero.condicion==undefined)
            return false
            this.sumidero.sewer_id=this.sewer.id
            this.$api.post('sumidero',this.sumidero).then(() => {
                //console.log(res.data)
                this.sumidero={}
                this.getFormulario2(this.sewer)
            })

        },
        modificar(pr){
            this.sewer=pr
            this.dialogReg=true
        },
        getFormulario1(pr){
            this.sewer=pr
            this.$api.get('pipeline/'+pr.id).then((res) => {
                this.listDetalle=res.data
                this.dialogDetalle=true
            })
        },
        getFormulario2(pr){
            this.sewer=pr
            this.$api.get('sumidero/'+pr.id).then((res) => {
                this.sumideros=res.data
                this.dialogSumidero=true
            })
        },
        getFormulario3(pr){
            this.sewer=pr
            this.$api.get('conducto/'+pr.id).then((res) => {
                this.conductos=res.data
                this.dialogConducto=true
            })
        },

        delDetalle(dt){
            this.$api.delete('pipeline/'+dt.id).then(() => {
                this.getFormulario1(this.sewer)
            })
            
        },
        delSum(dt){
            this.$api.delete('sumidero/'+dt.id).then(() => {
                this.getFormulario2(this.sewer)
            })
            
        },
        delCond(dt){
            this.$api.delete('conducto/'+dt.id).then(() => {
                this.getFormulario3(this.sewer)
            })
            
        },
        getDetalle(pr){
            this.$api.get('pipeline/'+pr.id).then((res) => {
                this.listDetalle=res.data
            })

        },
        retirar(props){
            this.detalle.splice(props.rowIndex,1);
        },
        onReset(){
            this.inspec={apertura:'NO',fecha:date.formatDate(new Date(), 'YYYY-MM-DD'),aro:false,paredes:false,solera:false}
            this.sewer={}
            this.selection=[]
            this.selection2=[]
            this.selection3=[]
            this.detalle=[]
        },
        getRasante(){
        this.$api.get('listMatPl').then((res) => {
            console.log(res.data)
                this.materiales=res.data
            })
        },
        getMaterial(){
        this.$api.get('listRasPl').then((res) => {
            console.log(res.data)
                this.rasantes=res.data
            })
        },
        getSewer(){
            this.$api.get('listSewer').then((res) => {
                console.log(res.data)
                this.sewers=res.data
            })

        },

        getDiam3(){
        this.$api.get('listDiametro').then((res) => {
            this.diametros
            res.data.forEach(r => {
                this.diametros.push(r.medida)
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

            if(this.dato.funcion==undefined) this.dato.funcion=''
            if(this.dato.gestion==undefined) this.dato.gestion=''
            this.dato.sewer_id=this.sewer.id
            this.$api.post('pipeline',this.dato).then(() => {
                //console.log(res.data)
                this.dato={}
                this.getDetalle(this.sewer)
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

            this.sewer.sedimento=cad
            this.sewer.estadofis=cad2

            if(this.sewer.id==undefined){


            this.$api.post('sewer',this.sewer).then((res) => {
                console.log(res.data)
                this.dialogReg=false
                this.onReset()
                this.getMaterial()
                this.getRasante()
                this.getSewer()
            });
            }
            else{
            
                this.$api.put('sewer/'+this.sewer.id,this.sewer).then((res) => {
                console.log(res.data)
                this.dialogReg=false
                this.onReset()
                this.getMaterial()
                this.getRasante()
                this.getSewer()
            });
            }

        },

    }
}
</script>
