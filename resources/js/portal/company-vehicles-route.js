import PageHeader from '../template/components/portal/PageHeader.vue';
import PortalBody from '../template/components/Body.vue';

import CompanyVehiclesList from '../template/views/portal/companies/vehicles/Vehicles.vue';
import CompanyVehicleNew from '../template/views/portal/companies/vehicles/Vehicle-Form.vue';
import CompanyVehicleEdit from '../template/views/portal/companies/vehicles/Vehicle-Form.vue';
import VehiclesList from '../template/views/portal/companies/vehicles/Vehicles.vue';
import VehicleNew from '../template/views/portal/companies/vehicles/Vehicle-Form.vue';

export default [
  {
    path: 'companies/:id/vehicles',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-company-vehicles',
        components: {header: PageHeader, default: CompanyVehiclesList},
        props: { header: {title:'وسایل نقلیه شرکت'} },
        meta: {
          title: "پرتال مدیریت - وسایل نقلیه شرکت"
        },
      },
      {
        path: 'new',
        name: 'portal-company-vehicle-new',
        components: {header: PageHeader, default: CompanyVehicleNew},
        props: { header: {title:'افزودن وسیله نقلیه جدید'} },
        meta: {
          title: "پرتال مدیریت - وسیله نقلیه جدید"
        },
      },
      {
        path: 'edit/:uid',
        name: 'portal-company-vehicle-edit',
        components: {header: PageHeader, default: CompanyVehicleEdit},
        props: { header: {title:'ویرایش وسیله نقلیه'} },
        meta: {
          title: "پرتال مدیریت - ویرایش وسیله نقلیه"
        },
      },
    ]
  }
];
