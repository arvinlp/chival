/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2021-07-20 19:54:53
 */
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/Body.vue';

import DriversList from '../../template/views/client/drivers/Drivers.vue';
import PartnearDriversList from '../../template/views/client/drivers/Partnear-Drivers.vue';
import DriverNew from '../../template/views/client/drivers/Driver-Form.vue';
import DriverEdit from '../../template/views/client/drivers/Driver-Form.vue';

import WaitingList from '../../template/views/client/drivers-waiting/Waiting-List.vue';
import WaitingForm from '../../template/views/client/drivers-waiting/Waiting-Form.vue';

export default [
  {
    path: 'drivers',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-drivers',
        components: {header: PageHeader, default: DriversList},
        props: { header: {title:'رانندگان شرکت'} },
        meta: {
          title: "پرتال شرکت - رانندگان شرکت"
        },
      },
      {
        path: 'new',
        name: 'client-driver-new',
        components: {header: PageHeader, default: DriverNew},
        props: { header: {title:'افزودن راننده جدید'} },
        meta: {
          title: "پرتال شرکت - راننده جدید"
        },
      },
      {
        path: 'edit/:id',
        name: 'client-driver-edit',
        components: {header: PageHeader, default: DriverEdit},
        props: { header: {title:'ویرایش راننده'} },
        meta: {
          title: "پرتال شرکت - ویرایش راننده"
        },
      },
    ]
  },{
    path: 'drivers-waiting-list',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-drivers-waiting-list',
        components: {header: PageHeader, default: WaitingList},
        props: { header: {title:'لیست نوبت شرکت'} },
        meta: {
          title: "پرتال شرکت - لیست نوبت شرکت"
        },
      },
      {
        path: 'add',
        name: 'client-driver-waiting-new',
        components: {header: PageHeader, default: WaitingForm},
        props: { header: {title:'افزودن راننده به لیست نوبت'} },
        meta: {
          title: "پرتال شرکت - افزودن راننده به لیست نوبت"
        },
      },
      {
        path: 'edit/:id',
        name: 'client-driver-waiting-edit',
        components: {header: PageHeader, default: WaitingForm},
        props: { header: {title:'ویرایش راننده در لیست نوبت'} },
        meta: {
          title: "پرتال شرکت - ویرایش راننده در لیست نوبت"
        },
      },
    ]
  },
  {
    path: 'partnear-drivers',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-partnear-drivers',
        components: {header: PageHeader, default: PartnearDriversList},
        props: { header: {title:'رانندگان شرکت‌های همکار'} },
        meta: {
          title: "پرتال شرکت - رانندگان شرکت‌های همکار"
        },
      },
    ]
  }
];
