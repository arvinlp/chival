/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2020-11-12 21:08:45
 */
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/Body.vue';

import RecordsList from '../../template/views/client/records/Records.vue';
import RecordNew from '../../template/views/client/records/Record-Form.vue';
import TravelRecords from '../../template/views/client/records/Travel-Records';

export default [
  {
    path: 'records',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-records',
        components: {header: PageHeader, default: RecordsList},
        props: { header: {title:'صورت وضعیت ها'} },
        meta: {
          title: "پرتال شرکت - صورت وضعیت ها"
        },
      },
      {
        path: 'new',
        name: 'client-record-new',
        components: {header: PageHeader, default: RecordNew},
        props: { header: {title:'افزودن صورت وضعیت جدید'} },
        meta: {
          title: "پرتال شرکت - افزودن صورت وضعیت"
        },
      },
      {
        path: 'edit/:id',
        name: 'client-record-edit',
        components: {header: PageHeader, default: RecordNew},
        props: { header: {title:'ویرایش صورت وضعیت'} },
        meta: {
          title: "پرتال شرکت - ویرایش صورت وضعیت"
        },
      },
      {
        path: 'transfer',
        children: [
          {
            path: '',
            name: 'client-record-transfer',
            components: {header: PageHeader, default: RecordNew},
            props: { header: {title:'لیست انتقال صورت وضعیت'} },
            meta: {
              title: "پرتال شرکت - لیست انتقال صورت وضعیت به کاربر دیگر"
            },
          },
          {
            path: 'new',
            name: 'client-record-transfer-new',
            components: {header: PageHeader, default: RecordNew},
            props: { header: {title:'انتقال صورت وضعیت به کاربر'} },
            meta: {
              title: "پرتال شرکت - انتقال صورت وضعیت به کاربر دیگر"
            },
          },
        ]
      },
      {
        path: 'tracking',
        name: 'client-record-tracking',
        components: {header: PageHeader, default: TravelRecords},
        props: { header: {title:'صدور کد رهگیری و چاپ صورت وضعیت'} },
        meta: {
          title: "پرتال شرکت - صدو کد رهگیری و چاپ صورت وضعیت"
        },
      },
    ]
  },
];
