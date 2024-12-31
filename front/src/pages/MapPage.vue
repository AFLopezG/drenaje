Copiar código
<template>
      <q-layout view="lHh Lpr lFf" class="bg-grey-2" >
        <q-page-container >
          <q-page class="q-pa-xs" >
            <div id="map" style="height: 300px;" ></div>
            <img id="mapImage">
          </q-page>
  </q-page-container>
  </q-layout>
</template>

<script>
import L from 'leaflet';
import 'leaflet/dist/leaflet.css'
import html2canvas from 'html2canvas'
import {SimpleMapScreenshoter} from 'leaflet-simple-map-screenshoter'
import 'leaflet-simple-map-screenshoter'

export default {
  name: 'MapPage',
  mounted() {
    // Obtener parámetros de la URL
   //const urlParams = new URLSearchParams(window.location.search);
    const lat = this.$route.query.lat
    const lon = this.$route.query.lon
    console.log(this.$route)
    // Inicializar el mapa
    const map = L.map('map', {renderer: L.canvas()}).setView([lat, lon], 17);

    // Añadir capa de OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: ''
    }).addTo(map);

    // Añadir marcador
    L.marker([lat, lon]).addTo(map);
    this.map=map
   /* html2canvas(document.getElementById('map'),{allowTaint : false,
      logging : true,
      taintTest: false,
      useCORS: true,
      onrendered:true}).then(function(canvas) {
                var img = canvas.toDataURL('image/png');
                document.getElementById('mapImage').src = img;
                console.log(img)
  })*/
  const simpleMapScreenshoter = new SimpleMapScreenshoter({
        hidden: true,
      });
    simpleMapScreenshoter.addTo(map);


simpleMapScreenshoter.takeScreen('image').then(imageData => {
        /*doc.addImage(imageData, 'PNG', 10, 60);
        const pdfData = doc.output('datauristring');
        const pdfFrame = document.querySelector('#pdfFrame');
        pdfFrame.src = pdfData;*/
        console.log(imageData)
        document.getElementById('mapImage').src = imageData;
      }).catch(error => {
        console.error('Error taking map screenshot:', error);
      });
  },
};
</script>

<style>
  #map {
    width: 300px;
    height: 300px;
  }
</style>  