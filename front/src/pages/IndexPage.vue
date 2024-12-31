<template>
  <q-page class="row items-center justify-evenly">
    <div class="row">
      <div class="col-3"><q-btn color="info" icon="picture_as_pdf" label="REPORTE" @click="onClick" /></div>
    </div>
  </q-page>
</template>

<script>

export default {
  name: 'IndexPage',
  data() {
    return {
      
    }
  },
  methods:{
    async onClick(){ 
        this.$api.get('reporte', {responseType: 'blob' }).then(res=>{
        
        // Crear una URL para el blob y desencadenar la descarga
        const url = window.URL.createObjectURL(new Blob([res.data]));
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', 'reporte.pdf');
        document.body.appendChild(link);
        link.click();

        // Limpiar el blob URL después de la descarga
        window.URL.revokeObjectURL(url)
      }).catch(err => {
          console.log(err.response.data)
          this.$q.notify({
            message: err.response.data.message,
            icon: 'close',
            color: 'red'
          })
      })
}
  }
  }
</script>