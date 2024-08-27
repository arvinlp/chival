import PageHeader from '../template/components/portal/PageHeader.vue';
import PortalBody from '../template/components/Body.vue';

import CompaniesList from '../template/views/portal/companies/Companies.vue';
import CompanyFormNew from '../template/views/portal/companies/Company-Form-New.vue';
import CompanyFormEdit from '../template/views/portal/companies/Company-Form-Edit.vue';

import CompanyUsersRoute from './company-users-route';
import CompanyVehiclesRoute from './company-vehicles-route';
import CompanyBasicRoute from './company-basic-route';

export default [
  {
    path: 'companies',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-companies',
        components: {header: PageHeader, default: CompaniesList},
        props: { header: {title:'لیست شرکت ها'} },
        meta: {
          title: "پرتال مدیریت - شرکت ها"
        },
      },
      {
        path: 'new',
        name: 'portal-companies-new',
        components: {header: PageHeader, default: CompanyFormNew},
        props: { header: {title:'افزودن شرکت جدید'} },
        meta: {
          title: "پرتال مدیریت - شرکت جدید"
        },
      },
      {
        path: 'edit/:id',
        name: 'portal-companies-edit',
        components: {header: PageHeader, default: CompanyFormEdit},
        props: { header: {title:'ویراش شرکت'} },
        meta: {
          title: "پرتال مدیریت - ویرایش شرکت"
        },
      },
    ]
  },
  {
    path: 'storges',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-companies-storage',
        components: {header: PageHeader, default: CompaniesList},
        props: { header: {title:'لیست انبارها'} },
        meta: {
          title: "پرتال مدیریت - انبارها"
        },
      },
      {
        path: 'new',
        name: 'portal-companies-storage-new',
        components: {header: PageHeader, default: CompaniesList},
        props: { header: {title:'افزودن انبار جدید'} },
        meta: {
          title: "پرتال مدیریت - انبار جدید"
        },
      },
    ]
  },
  {
    path: 'drivers',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-companies-drivers',
        components: {header: PageHeader, default: CompaniesList},
        props: { header: {title:'لیست راننده ها'} },
        meta: {
          title: "پرتال مدیریت - راننده ها"
        },
      },
      {
        path: 'new',
        name: 'portal-companies-drivers-new',
        components: {header: PageHeader, default: CompaniesList},
        props: { header: {title:'افزودن راننده جدید'} },
        meta: {
          title: "پرتال مدیریت - وسیله راننده جدید"
        },
      },
    ]
  },
  {
    path: 'contracts',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-companies-contracts',
        components: {header: PageHeader, default: CompaniesList},
        props: { header: {title:'لیست قرارداد ها'} },
        meta: {
          title: "پرتال مدیریت - قرارداد ها"
        },
      },
      {
        path: 'new',
        name: 'portal-companies-contracts-new',
        components: {header: PageHeader, default: CompaniesList},
        props: { header: {title:'افزودن قرارداد جدید'} },
        meta: {
          title: "پرتال مدیریت - وسیله قرارداد جدید"
        },
      },
    ]
  },
  ...CompanyUsersRoute,
  ...CompanyVehiclesRoute,
  ...CompanyBasicRoute
];
