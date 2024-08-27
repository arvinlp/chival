/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2021-07-20 20:22:03
 */
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/Body.vue';

import BasicSetting from '../../template/views/client/setting/Basic.vue';
import TravelSetting from '../../template/views/client/setting/Travel.vue';

import RoutesList from '../../template/views/client/route/Routes.vue';
import RouteNew from '../../template/views/client/route/Route-Form.vue';

import PartnersList from '../../template/views/client/partnears/Partnears.vue';
import PartnerNew from '../../template/views/client/partnears/Partnear-Form.vue';

import RecordsList from '../../template/views/client/records/Records.vue';
import RecordNew from '../../template/views/client/records/Record-Form.vue';

export default [
  {
    path: 'setting',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-setting',
        components: {header: PageHeader, default: BasicSetting},
        props: { header: {title:'تنظیمات پایه سیستم'} },
        meta: {
          title: "پرتال شرکت - تنظیمات پایه سیستم"
        },
      },
      {
        path: '/travel',
        name: 'client-setting-travel',
        components: {header: PageHeader, default: TravelSetting},
        props: { header: {title:'تنظیمات سفر'} },
        meta: {
          title: "پرتال شرکت - تنظیمات سفر"
        },
      },
    ],
  },
  {
    path: 'routes',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-routes',
        components: {header: PageHeader, default: RoutesList},
        props: { header: {title:'مسیرهای سیر شرکت'} },
        meta: {
          title: "پرتال شرکت - مسیرهای سیر شرکت"
        },
      },
      {
        path: 'new',
        name: 'client-route-new',
        components: {header: PageHeader, default: RouteNew},
        props: { header: {title:'افزودن خط سیر جدید'} },
        meta: {
          title: "پرتال شرکت - خط سیر جدید"
        },
      },
      {
        path: 'edit/:id',
        name: 'client-route-edit',
        components: {header: PageHeader, default: RouteNew},
        props: { header: {title:'ویرایش خط سیر'} },
        meta: {
          title: "پرتال شرکت - ویرایش خط سیر"
        },
      },
    ]
  },
  {
    path: 'partnears',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-partnears',
        components: {header: PageHeader, default: PartnersList},
        props: { header: {title:'شرکت‌های همکار'} },
        meta: {
          title: "پرتال شرکت - شرکت‌های همکار"
        },
      },
      {
        path: 'new',
        name: 'client-partnear-new',
        components: {header: PageHeader, default: PartnerNew},
        props: { header: {title:'افزودن همکاری جدید'} },
        meta: {
          title: "پرتال شرکت - همکاری شرکت"
        },
      },
      {
        path: 'edit/:id',
        name: 'client-partnear-edit',
        components: {header: PageHeader, default: PartnerNew},
        props: { header: {title:'ویرایش همکاری شرکت'} },
        meta: {
          title: "پرتال شرکت - ویرایش همکاری  شرکت"
        },
      },
    ]
  },
];
