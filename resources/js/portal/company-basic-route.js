import PageHeader from '../template/components/portal/PageHeader.vue';
import PortalBody from '../template/components/Body.vue';

import CompanyRoutesList from '../template/views/portal/companies/route/Routes.vue';
import CompanyRouteNew from '../template/views/portal/companies/route/Route-Form.vue';

import CompanyPartnersList from '../template/views/portal/companies/partnears/Partnears.vue';
import CompanyPartnerNew from '../template/views/portal/companies/partnears/Partnear-Form.vue';

export default [
  {
    path: 'companies/:id/routes',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-company-routes',
        components: {header: PageHeader, default: CompanyRoutesList},
        props: { header: {title:'مسیرهای سیر شرکت'} },
        meta: {
          title: "پرتال مدیریت - مسیرهای سیر شرکت"
        },
      },
      {
        path: 'new',
        name: 'portal-company-route-new',
        components: {header: PageHeader, default: CompanyRouteNew},
        props: { header: {title:'افزودن خط سیر جدید'} },
        meta: {
          title: "پرتال مدیریت - خط سیر جدید"
        },
      },
      {
        path: 'edit/:uid',
        name: 'portal-company-route-edit',
        components: {header: PageHeader, default: CompanyRouteNew},
        props: { header: {title:'ویرایش خط سیر'} },
        meta: {
          title: "پرتال مدیریت - ویرایش خط سیر"
        },
      },
    ]
  },{
    path: 'routes',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-routes',
        components: {header: PageHeader, default: CompanyRoutesList},
        props: { header: {title:'مسیرهای سیر شرکت'} },
        meta: {
          title: "پرتال مدیریت - مسیرهای سیر شرکت"
        },
      },
      {
        path: 'new',
        name: 'portal-route-new',
        components: {header: PageHeader, default: CompanyRouteNew},
        props: { header: {title:'افزودن خط سیر جدید'} },
        meta: {
          title: "پرتال مدیریت - خط سیر جدید"
        },
      },
    ]
  },/** */
  {
    path: 'companies/:id/partnears',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-company-partnears',
        components: {header: PageHeader, default: CompanyPartnersList},
        props: { header: {title:'شرکت‌های همکار شرکت'} },
        meta: {
          title: "پرتال مدیریت - شرکت‌های همکار شرکت"
        },
      },
      {
        path: 'new',
        name: 'portal-company-partnear-new',
        components: {header: PageHeader, default: CompanyPartnerNew},
        props: { header: {title:'افزودن همکاری جدید'} },
        meta: {
          title: "پرتال مدیریت - همکاری دو شرکت"
        },
      },
      {
        path: 'edit/:uid',
        name: 'portal-company-partnear-edit',
        components: {header: PageHeader, default: CompanyPartnerNew},
        props: { header: {title:'ویرایش همکاری دو شرکت'} },
        meta: {
          title: "پرتال مدیریت - ویرایش همکاری دو شرکت"
        },
      },
    ]
  },{
    path: 'partnears',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-partnears',
        components: {header: PageHeader, default: CompanyPartnersList},
        props: { header: {title:'شرکت‌های همکار شرکت'} },
        meta: {
          title: "پرتال مدیریت - شرکت‌های همکار شرکت"
        },
      },
      {
        path: 'new',
        name: 'portal-partnear-new',
        components: {header: PageHeader, default: CompanyPartnerNew},
        props: { header: {title:'افزودن همکاری جدید'} },
        meta: {
          title: "پرتال مدیریت - همکاری دو شرکت"
        },
      },
      {
        path: 'edit/:uid',
        name: 'portal-partnear-edit',
        components: {header: PageHeader, default: CompanyPartnerNew},
        props: { header: {title:'ویرایش همکاری دو شرکت'} },
        meta: {
          title: "پرتال مدیریت - ویرایش همکاری دو شرکت"
        },
      },
    ]
  },
];
