/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2021-05-30 10:15:46
 */
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/Body.vue';

import List from '../../template/views/client/exclusive/Exclusive';
import Form from '../../template/views/client/exclusive/Exclusive-Form';

export default [
  {
    path: 'exclusive',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-exclusives',
        components: {header: PageHeader, default: List},
        props: { header: {title:'دربستی'} },
        meta: {
          title: "پرتال شرکت - دربستی"
        },
      },
      {
        path: 'new',
        name: 'client-exclusive-new',
        components: {header: PageHeader, default: Form},
        props: { header: {title:'دربستی'} },
        meta: {
          title: "پرتال شرکت - سفر دربستی جدید"
        },
      },
      {
        path: ':id',
        name: 'client-exclusive-edit',
        components: {header: PageHeader, default: Form},
        props: { header: {title:'دربستی و مشاهده مسافرین'} },
        meta: {
          title: "پرتال شرکت - مشاهده مسافرین و دربستی برای وسیله نقلیه"
        },
      },
      {
        path: 'cancel/:id',
        name: 'client-exclusive-cancel',
        components: {header: PageHeader, default: Form},
        props: { header: {title:'لغو سفر دربستی'} },
        meta: {
          title: "پرتال شرکت - لغو سفر دربستی"
        },
      },
    ]
  },
];
