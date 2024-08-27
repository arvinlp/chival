/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2020-04-05 22:50:23
 */
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/Body.vue';

import DriversList from '../../template/views/client/drivers/Drivers.vue';
import DriverNew from '../../template/views/client/drivers/Driver-Form.vue';
import DriverEdit from '../../template/views/client/drivers/Driver-Form.vue';

export default [
  {
    path: 'drivers-list',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-turn-list',
        components: {header: PageHeader, default: DriversList},
        props: { header: {title:'لیست نوبت شرکت'} },
        meta: {
          title: "پرتال شرکت - لیست نوب شرکت"
        },
      },
      {
        path: 'new',
        name: 'client-turn-new',
        components: {header: PageHeader, default: DriverNew},
        props: { header: {title:'افزودن راننده به لیست نوبت'} },
        meta: {
          title: "پرتال شرکت - افزودن راننده به لیست نوبت"
        },
      },
    ]
  }
];
