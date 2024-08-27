/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:36:34 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2021-02-07 20:42:27
 */

import store from '../store'
import Login from '../template/views/Auth/Login.vue'
import Logout from '../template/views/Auth/Logout.vue'
import Register from '../template/views/Auth/Register.vue'

import MainBody from '../template/components/MainBody.vue';

import UserRoutes from './users/main-route'

import ManagerRoutes from './manager/main-route'
import TravelRecordsPrintCheck from '../template/views/client/ticket-selling/Print-Check';

const router = [
  {
    path: '/print',
    name: 'print',
    component: TravelRecordsPrintCheck,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
    beforeEach: (to, from, next) => {
      if(store.getters.isType != "client"){
        next()
      }else{
        next({
          path: '/',
          query: { redirect: to.fullPath }
        })
      }
    },
    meta: { 
      guestOnly: true
    }
  },
  {
    path: '/register',
    name: 'register',
    component: Register,
    beforeEach: (to, from, next) => {
      if(store.getters.isType != "client"){
        next()
      }else{
        next({
          path: '/',
          query: { redirect: to.fullPath }
        })
      }
    },
    meta: { 
      guestOnly: true
    }
  },
  {
    path: '/logout',
    name: 'logout',
    component: Logout,
    beforeEach: (to, from, next) => {
      if(store.getters.isType == "client"){
        next()
      }else{
        next({
          path: '/login',
          query: { redirect: to.fullPath }
        })
      }
    },
    meta: { 
      requiresAuth: true
    }
  },
  {
    path: '/',
    name: 'client-dash',
    component: MainBody,
    beforeEach: (to, from, next) => {
      if(store.getters.isType == "client"){
        next()
      }else{
        next({
          path: '/login',
          query: { redirect: to.fullPath }
        })
      }
    },
    children: [
      ...UserRoutes,
      ...ManagerRoutes,
    ],
  },
];

export default router
