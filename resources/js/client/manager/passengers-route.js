/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2020-04-05 23:16:34
 */
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/Body.vue';

import RoutesList from '../../template/views/client/route/Routes.vue';
import RouteNew from '../../template/views/client/route/Route-Form.vue';

export default [
  {
    path: 'passengers',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-passengers',
        components: {header: PageHeader, default: RoutesList},
        props: { header: {title:'مسافران'} },
        meta: {
          title: "پرتال شرکت - مسافران"
        },
      },
      {
        path: 'new',
        name: 'client-passenger-new',
        components: {header: PageHeader, default: RouteNew},
        props: { header: {title:'افزودن مسافر جدید'} },
        meta: {
          title: "پرتال شرکت - مسافر جدید"
        },
      },
      {
        path: 'edit/:id',
        name: 'client-passenger-edit',
        components: {header: PageHeader, default: RouteNew},
        props: { header: {title:'ویرایش اطلاعات مسافر'} },
        meta: {
          title: "پرتال شرکت - ویرایش اطلاعات مسافر"
        },
      },
    ]
  },
  {
    path: 'passengers-waiting-list',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-passengers-waiting-list',
        components: {header: PageHeader, default: RoutesList},
        props: { header: {title:'لیست انتظار مسافران'} },
        meta: {
          title: "پرتال شرکت - لیست انتظار مسافران"
        },
      },
      {
        path: 'new',
        name: 'client-passenger-waiting-new',
        components: {header: PageHeader, default: RouteNew},
        props: { header: {title:'افزودن مسافر به لیست انتظار جدید'} },
        meta: {
          title: "پرتال شرکت - مسافر به لیست انتظار جدید"
        },
      },
      {
        path: 'edit/:id',
        name: 'client-passenger-waiting-edit',
        components: {header: PageHeader, default: RouteNew},
        props: { header: {title:'ویرایش اطلاعات مسافر در لیست انتظار'} },
        meta: {
          title: "پرتال شرکت - ویرایش اطلاعات مسافر در لیست انتظار"
        },
      },
    ]
  },
];
