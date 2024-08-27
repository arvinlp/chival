/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2021-07-24 20:07:50
 */
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/Body.vue';

import RoutesList from '../../template/views/client/route/Routes.vue';
import RouteNew from '../../template/views/client/route/Route-Form.vue';

export default [
  {
    path: 'ticket',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-ticket',
        components: {header: PageHeader, default: RoutesList},
        props: { header: {title:'فروش بیلط'} },
        meta: {
          title: "پرتال شرکت - فروش بلیط"
        },
      },
      {
        path: 'passengers-pendding',
        name: 'client-ticket-pendding',
        components: {header: PageHeader, default: RouteNew},
        props: { header: {title:'لیست انتظار مسافران'} },
        meta: {
          title: "پرتال شرکت - لیست انتظار مسافران"
        },
      },
      {
        path: 'passengers-pendding',
        component:PortalBody,
        children: [
          {
            path: '',
            name: 'client-passengers-pendding',
            components: {header: PageHeader, default: RouteNew},
            props: { header: {title:'لیست انتظار مسافران'} },
            meta: {
              title: "پرتال شرکت - لیست انتظار مسافران"
            },
          },
          {
            path: 'new',
            name: 'client-passenger-pendding-new',
            components: {header: PageHeader, default: RouteNew},
            props: { header: {title:'افزودن مسافر به لیست انتظار'} },
            meta: {
              title: "پرتال شرکت - افزودن مسافر به لیست انتظار مسافران"
            },
          },
          {
            path: 'edit/:id',
            name: 'client-passenger-pendding-edit',
            components: {header: PageHeader, default: RouteNew},
            props: { header: {title:'ویرایش مسافر در لیست انتظار'} },
            meta: {
              title: "پرتال شرکت - ویرایش مسافر در لیست انتظار"
            },
          }
        ],
      },
    ]
  },
];
