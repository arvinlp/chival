/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2021-07-20 19:54:58
 */
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/Body.vue';

import VehiclesList from '../../template/views/client/vehicles/Vehicles.vue';
import PartnerVehiclesList from '../../template/views/client/vehicles/Partnear-Vehicles.vue';
import VehicleNew from '../../template/views/client/vehicles/Vehicle-Form.vue';
import VehicleEdit from '../../template/views/client/vehicles/Vehicle-Form.vue';

export default [
  {
    path: 'vehicles',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-vehicles',
        components: {header: PageHeader, default: VehiclesList},
        props: { header: {title:'وسایل نقلیه شرکت'} },
        meta: {
          title: "پرتال شرکت - وسایل نقلیه شرکت"
        },
      },
      {
        path: 'new',
        name: 'client-vehicle-new',
        components: {header: PageHeader, default: VehicleNew},
        props: { header: {title:'افزودن وسیله نقلیه جدید'} },
        meta: {
          title: "پرتال شرکت - وسیله نقلیه جدید"
        },
      },
      {
        path: 'edit/:id',
        name: 'client-vehicle-edit',
        components: {header: PageHeader, default: VehicleEdit},
        props: { header: {title:'ویرایش وسیله نقلیه'} },
        meta: {
          title: "پرتال شرکت - ویرایش وسیله نقلیه"
        },
      },
    ]
  },
  {
    path: 'partnear-vehicles',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-partnear-vehicles',
        components: {header: PageHeader, default: PartnerVehiclesList},
        props: { header: {title:'وسایل نقلیه شرکت‌های همکار'} },
        meta: {
          title: "پرتال شرکت - وسایل نقلیه شرکت‌های همکار"
        },
      },
    ]
  }
];
