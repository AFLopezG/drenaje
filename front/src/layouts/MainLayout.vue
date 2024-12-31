<template>
  <q-layout view="lHh Lpr lFf">
    <q-header elevated>
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          aria-label="Menu"
          @click="leftDrawerOpen=!leftDrawerOpen"
        />
        <q-toolbar-title>
          <div class="row">
            <div class="">            <img             src="/logo.png"            style="height: 40px; width: 40px;"      /></div>
          </div>

        </q-toolbar-title>

        <div>{{ store.user.name }}           
          <q-btn
            flat
            dense
            round
            icon="logout"
            aria-label="Logout"
            @click="logout"
          /></div>
      </q-toolbar>
    </q-header>

    <q-drawer
      v-model="leftDrawerOpen"
      show-if-above
      bordered
      :width="250"
    >
    <q-list bordered class="rounded-borders">
        <q-item-label header class="text-center text-bold bg-red-8 text-white">
          Opciones
        </q-item-label>

        <q-item clickable dense to="/" exact active-class="bg-primary text-white">
          <q-item-section avatar><q-icon name="o_home" /></q-item-section>
          <q-item-section><q-item-label>Principal</q-item-label><q-item-label caption class="text-grey-2"></q-item-label></q-item-section>
      </q-item>
      <q-expansion-item  active-class="bg-primary text-white" dense exact expand-separator icon="o_people" label="Usuarios" to="/usuarios" expand-icon="null" v-if="store.booluser"/>
      <q-expansion-item  active-class="bg-primary text-white" dense exact expand-separator icon="device_hub" label="Inspeccion" to="/inspeccion" expand-icon="null" v-if="store.boolver"/>
     
      </q-list>
    </q-drawer>

    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script >
import { defineComponent, ref } from 'vue';
import { globalStore } from '../stores/globalStore'
export default defineComponent({
  name: 'MainLayout',
  data() {
    return {
      leftDrawerOpen: ref(false),
      store: globalStore( )
    }
  },

  created () {
    if(!this.store.isLoggedIn)
    this.$router.push('/login')

  },
  methods:{
    logout () {
      this.$q.dialog({
        title: 'Cerrar sesión',
        message: '¿Está seguro que desea cerrar sesión?',
        cancel: true,
        persistent: true
      }).onOk(() => {
        this.$q.loading.show()
        this.$api.post('logout').then(() => {
          globalStore().user = {}
          localStorage.removeItem('tokenDrenaje')
          globalStore().isLoggedIn = false
          this.$router.push('/login')
          this.$q.loading.hide()
          globalStore().isLoggedIn = false
          globalStore().booluser = false
        })
      })
    
    },
  }

});
</script>
