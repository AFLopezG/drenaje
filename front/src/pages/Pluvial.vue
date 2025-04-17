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
                    <div class="col-md-4 col-xs-12 q-pa-xs"><q-select v-model="sewer.diametro" :options="diametros2" label="Diametro Tapa (m)" dense outlined/></div>
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
                    <div class="col-md-6 col-xs-12 q-pa-xs"><q-select v-model="sewer.estadotapa" :options="['BUENA','REGULAR','MALO']" label="Estado de Tapa *" dense outlined/></div>
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
                        <q-toggle class="q-pa-xs" v-model="sewer.piedra"  label="PIEDRA" color="amber" dense/>
                        <q-toggle class="q-pa-xs" v-model="sewer.lodo"  label="LODO" color="amber" dense/>
                        <q-toggle class="q-pa-xs" v-model="sewer.arena"  label="ARENA" color="amber" dense/>
                        <q-toggle class="q-pa-xs" v-model="sewer.basura"  label="BASURA" color="amber" dense/>
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
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="conducto.ancho"  label="Ancho Tapa *" type="number" step="0.01" dense outlined/></div>
                    <div class="col-md-3 col-xs-6 q-pa-xs"><q-input v-model="conducto.alto"  label="Alto Tapa *" type="number" step="0.01" dense outlined/></div>
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
            diametros2:[],
            listado:[],
            sumideros:[],
            conductos:[],
            conducto:{},
            sewer:{apertura:'NO',fecha:date.formatDate(new Date(), 'YYYY-MM-DD'),aro:false,paredes:false,solera:false,piedra:false,lodo:false,arena:false,basura:false},
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
        this.getDiam2()
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
            this.inspec={apertura:'NO',fecha:date.formatDate(new Date(), 'YYYY-MM-DD'),aro:false,paredes:false,solera:false,piedra:false,lodo:false,arena:false,basura:false}
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
            this.diametros=[]
            res.data.forEach(r => {
                this.diametros.push(r.medida)
            });
            })
        },
        getDiam2(){
        this.$api.get('listDiamplg').then((res) => {
            this.diametros2=[]
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
            /*let cad=''
            //let cad2=''

            this.selection2.forEach(r => {
                cad+=r+ ', '
            });
            this.selection3.forEach(r => {
                cad2+=r+ ', '
            });

            this.sewer.sedimento=cad*/
            //this.sewer.estadofis=cad2

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
        impresion(prop){
            
            this.$api.get('sewer/'+prop.id).then((res) => {
                console.log(res.data)
                let pr=res.data[0]

            let detalle=pr.pipelines
            let sumid=pr.sumideros
            let condu=pr.conductos
            let defecto=''
            if(pr.aro) 
                defecto+=' ARO '
            else
                defecto+=''
            if(pr.paredes) 
                defecto+=' PAREDES '
            else
                defecto+=''
            if(pr.solera) 
                defecto+=' SOLERA '
            else
                defecto+=''

            let sedim=''
            if(pr.piedra) 
                sedim+=' PIEDRA '
            else
                sedim+=''
            if(pr.lodo) 
                sedim+=' LODO '
            else
                sedim+=''
            if(pr.arena) 
                sedim+=' ARENA '
            else
                sedim+=''
            if(pr.basura) 
                sedim+=' BASURA '
            else
                sedim+=''

            if(pr.estadotapa==null) pr.estadotapa=''
            if(pr.condicion==null) pr.condicion=''
            if(pr.sedimento==null) pr.sedimento=''
            if(pr.alturasedi==null) pr.alturasedi=''
            if(pr.estadosol==null) pr.estadosol=''
            if(pr.escalon==null) pr.escalon=''
            if(pr.estadofis==null) pr.estadofis=''
            let contenido=''
            let contenido2=''
            let contenido3=''
            let num=1
            let num2=1
            let num3=1
            let ingreso=detalle[0].diametro
            let salida=detalle[1].diametro
            detalle.forEach(r => {
                if(r.gestion==null) r.gestion=''
                contenido+='<tr><td>'+num+'</td><td>'+r.tipo+'</td><td>'+r.funcion+'</td><td>'+r.gestion+'</td><td>'+r.diametro+'</td><td>'+r.material+'</td><td>'+r.profundidad+'</td><td>'+r.origen+'</td><td>'+r.destino+'</td></tr>'
                num++
            });    
            condu.forEach(p => {
                contenido3+='<tr><td>'+num2+'</td><td>'+p.tipo+'</td><td>'+p.material+'</td><td>'+p.largo+'</td><td>'+p.ancho+'</td><td>'+p.alto+'</td><td>'+p.diametro+'</td><td>'+p.profundidad+'</td><td>'+p.origen+'</td><td>'+p.destino+'</td></tr>'
                num2++
            });
            sumid.forEach(m => {
                contenido2+='<tr><td>'+num3+'</td><td>'+m.material+'</td><td>'+m.tapa+'</td><td>'+m.estado+'</td><td>'+m.apertura+'</td><td>'+m.sedimento+'</td><td>'+m.altsed+'</td><td>'+m.condicion+'</td</tr>'
                num3++
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
                height:25px;
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
                .img1{width:70px;height:70px; text-align:center;}
                        .contenedor {
            display: flex;
            gap: 10px; /* Espacio entre los divs */
            justify-content: space-between;
        }

        .item {
            width: 20%;
            padding: 10px;
            border: 1px solid #000;
            font-size:11px
        }
        .leaflet-control-attribution {
            display: none; /* Oculta el nombre de Leaflet en el pie del mapa */
        }
            </style>
            </head>
            <body>
            <table class='tab1'>
                <tr><td style='width:15%'><img src='escudo.jpg' class='img1'></td>
                    <td>CATASTRO DE LA RED DE ALCANTARILLADO PLUVIAL<br>GOBIERNO AUTÓNOMO MUNICIPAL DE ORURO<br>UNIDAD DE DRENAJE URBANO</td>
                    <td style='width:15%'><img src='udu.jpeg' class='img1'></td></tr>
            </table>
            <table class='tab1'>
                <tr><td>CROQUIS</td><td>Nro C.I. :`+pr.codigo+` </td><td>SUMIDERO</td></tr>
                <tr><td  style='width:40%; height:200px; text-align:right; vertical-align:top;padding:5px'><img src='norte.jpg' width='20px'> </td>
                <td style='width:30%'><div style='position: relative'><span style='position: absolute;top:20px; left:70px;'>`+pr.altura+' m</span> <span style="position: absolute;top:80px; left:20px;">'+ingreso+' mm    </span> <span style="position: absolute;top:80px; right:20px;">'+salida+` mm</span>
                    <img src='camara.png' style='height:150px;'></div></td>
                <td style='width:30%'><img src='sumidero.png' style='height:150px;'></td>
                </tr>
             </table>
             <table class='tab2'>
                <tr><th>Diametro de Tapa: </th><td>`+pr.diametro+'</td><th>Altura de Tapa: </th><td>'+pr.altapa+`</td></tr>
                <tr><th>Rasante: </th><td>`+pr.rasante+'</td><th>Material Rasante: </th><td>'+pr.material+`</td></tr>
             </table>
             <table class='tab2'>
                <tr><th>Ubicacion: </th><td colspan=5>`+pr.ubicacion+`</td></tr>
                <tr><th>Longitud (X): </th><td>`+pr.lng+'</td><th>Latitud (Y): </th><td>'+pr.lat+'</td><th>Elevacion (Z): </th><td>'+pr.elevacion+`</td></tr>
            </table>

            <table class='tab3'><tr><th>Nro C.I. : `+pr.codigo+'</th><th>CARACTERISTICAS DEL POZO</th><th>FECHA: ' +pr.fecha+`</th></tr></table>
            <table class='tab4' style='text-align:left'>
                <tr>
                    <td>
                    <b>Tipo de tapa Estado : </b>`+pr.estadotapa+`<br>
                    <b>Posibilidad de apertura : </b>`+pr.apertura+`<br>
                    <b>Tipo de C.I.  : </b>`+pr.tipo+`<br>
                    <b>Drenaje  : </b>`+pr.drenaje+`<br>
                    <b>Estado de C.I. : </b>`+pr.estadoci+`<br>
                    </td>
                    <td>
                    <b>Localizacion de Defectos : </b>`+defecto+`<br>
                    <b>Condicion de C.I. : </b>`+pr.condicion+`<br>
                    <b>Tipo de Sedimento : </b>`+sedim+`<br>
                    <b>Condicion de Escalones : </b>`+pr.escalon+`<br>
                    </td>
                </tr>
                <tr><td colspan=2><b>Observacion</b><br>`+pr.observacion+`<br></td></tr>
                <tr><th colspan=2 style='text-align:center'>TUBERIAS EN C.I.</th></tr>
            </table>
            <table class='tab3'>
                <tr><th>No</th><th>TIPO</th><th>FUNC</th><th>GESTION</th><th>DIAMETRO</th><th>MATERIAL</th><th>PROFUNDIDAD</th><th>ORIGEN</th><th>DESTINO</th></tr>
                `+contenido+`
            </table>
            <div style='text-align:center;font-weight: bold;'>SUMIDEROS</div>
                        <table class='tab3'>
                <tr><th>No</th><th>MATERIAL</th><th>TAPA</th><th>ESTADO</th><th>APERTURA</th><th>SEDIMENTO</th><th>ALTURA SED</th><th>CONDICION</th></tr>
                `+contenido2+`
            </table>

            <div style='text-align:center;font-weight: bold;'>TUBERIAS EN SUMIDEROS</div>
            <table class='tab3'>
                <tr><th>No</th><th>TIPO</th><th>MATERIAL</th><th>LARGO</th><th>ANCHO</th><th>ALTO</th><th>DIAMETRO</th><th>PROFUNDIDAD</th><th>ORIGEN</th><th>DESTINO</th></tr>
                `+contenido3+`
            </table>

            </body>
            </html>
            `
            document.getElementById('myelement').innerHTML = cadena
            const d = new Printd()
            d.print( document.getElementById('myelement') ) 
        })

        },
    }
}
</script>
