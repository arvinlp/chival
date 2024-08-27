/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2020-04-06 22:14:07
 */
import store from '../../store'
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/client/Body.vue';

import Dashboard from '../../template/views/client/Dashboard.vue';

import Drivers from './drivers-route';
import Ticket from './ticket-route';

export default [
  {
    path: '',
    component:PortalBody,
    beforeEnter: (to, from, next) => {
      if(store.getters.isLevel >= 0 && store.getters.isLevel < 100 ){
        next({
          path: '/manager',
        })
      }else if(store.getters.isLevel >= 100 && store.getters.isLevel < 200 ){
        next({
          path: '/technical',
        })
      }else if(store.getters.isLevel >= 200 && store.getters.isLevel < 300 ){
        next({
          path: '/manager',
        })
      }else if(store.getters.isLevel >= 300 && store.getters.isLevel < 400 ){
        next({
          path: '/manager',
        })
      }else if(store.getters.isLevel >= 400 ){
        next({
          path: '/500',
        })
      }else {
        next()
      }
    },
    children: [
      {
        path: '',
        name: 'user-dashboard',
        components: {header: PageHeader, default: Dashboard},
        props: { header: {title:'داشبورد پرسنل'} },
        meta: {
          title: "پرتال شرکت - داشبورد پرسنل"
        },
        ...Drivers,
        ...Ticket
      },
    ]
  },
];
