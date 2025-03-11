import { RouteRecordRaw } from 'vue-router'
import MainLayout from 'layouts/MainLayout.vue'
import IndexPage from 'pages/IndexPage.vue'
import Inspeccion from 'pages/Inspeccion.vue'
import Login from 'pages/Login.vue'
import Map from 'pages/MapPage.vue'
import Usuarios from 'pages/Usuarios.vue'
import Pluvial from 'src/pages/Pluvial.vue'

const routes: RouteRecordRaw[] = [
  {
    path: '/',
    component: MainLayout,
    children: [
      { path: '', component: IndexPage, meta: { requiresAuth: true } },
      { path: '/inspeccion', component: Inspeccion, meta: { requiresAuth: true } },
      { path: '/usuarios', component: Usuarios, meta: { requiresAuth: true } },
      { path: '/pluvial', component: Pluvial, meta: { requiresAuth: true } },
      
    ] 
  },
  {
     path: '/map', component: Map 
  },
  {
    path: '/login',
    component: Login
  },
  // Always leave this as last one,
  // but you can also remove it
  {
    path: '/:catchAll(.*)*',
    component: () => import('pages/ErrorNotFound.vue'),
  },
];

export default routes;
