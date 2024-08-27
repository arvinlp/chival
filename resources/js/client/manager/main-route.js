/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2021-05-30 10:19:43
 */
import store from '../../store';
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/client/Body-Manager.vue';

import Dashboard from '../../template/views/client/Dashboard-Manager.vue';

import Basic from './basic-route';
import Users from './users-route';
import Vehicles from './vehicles-route';
import Drivers from './drivers-route';
import Ticket from './ticket-route';
import Records from './records-route';
import Exclusives from './exclusive-route';
import Passengers from './passengers-route';

export default [
  {
    path: '/manager',
    component: PortalBody,
    beforeEnter: (to, from, next) => {
      if (store.getters.isLevel >= 0 && store.getters.isLevel < 100) {
        next()
      } else {
        next({
          path: '/',
        })
      }
    },
    children: [
      {
        path: '',
        name: 'manager-dashboard',
        components: { header: PageHeader, default: Dashboard },
        props: { header: { title: 'داشبورد مدیریت' } },
        meta: {
          title: "پرتال شرکت - داشبورد مدیریت"
        },
      },
      ...Basic,
      ...Users,
      ...Vehicles,
      ...Drivers,
      ...Ticket,
      ...Records,
      ...Exclusives,
      ...Passengers,
    ]
  },
];
