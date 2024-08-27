/*
 * @Author: arvinlp 
 * @Date: 2020-03-03 18:50:47 
 * Copyright by Arvin Loripour 
 * WebSite : http://www.arvinlp.ir 
 * @Last Modified by: Arvin.Loripour
 * @Last Modified time: 2020-03-06 19:31:43
 */
import PageHeader from '../../template/components/client/PageHeader.vue';
import PortalBody from '../../template/components/Body.vue';

import UsersList from '../../template/views/client/users/Users.vue';
import UsersForm from '../../template/views/client/users/Users-Form.vue';
import UserLogs from '../../template/views/client/users/Users-Logs.vue';

// import RoleList from '../template/views/client/access/Roles.vue';
// import RolesForm from '../template/views/client/access/Roles-Form.vue';

import WorkTimesList from '../../template/views/client/users/WorkTimes.vue';
import WorkTimesForm from '../../template/views/client/users/WorkTimes-Form.vue';

export default [
  {
    path: 'users',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-users',
        components: {header: PageHeader, default: UsersList},
        props: { header: {title:'یست پرسنل'} },
        meta: {
          title: "پرتال شرکت - پرسنل"
        },
      },
      {
        path: 'new',
        name: 'client-user-new',
        components: {header: PageHeader, default: UsersForm},
        props: { header: {title:'افزودن پرسنل جدید'} },
        meta: {
          title: "پرتال شرکت - پرسنل جدید"
        },
      },
      {
        path: 'edit/:id',
        name: 'client-user-edit',
        components: {header: PageHeader, default: UsersForm},
        props: { header: {title:'ویرایش پرسنل'} },
        meta: {
          title: "پرتال شرکت - ویرایش پرسنل"
        },
      },
      {
        path: 'logs/:id',
        name: 'client-user-logs',
        components: {header: PageHeader, default: UserLogs},
        props: { header: {title:'تاریخچه پرسنل'} },
        meta: {
          title: "پرتال شرکت - تاریخچه پرسنل"
        },
      },
    ]
  },
  // {
  //   path: 'roles',
  //   component:PortalBody,
  //   children: [
  //     {
  //       path: '',
  //       name: 'client-roles',
  //       components: {header: PageHeader, default: RoleList},
  //       props: { header: {title:'لیست سطوح دسترسی'} },
  //       meta: {
  //         title: "پرتال شرکت - سطوح دسترسی"
  //       },
  //     },
  //     {
  //       path: 'new',
  //       name: 'client-role-new',
  //       components: {header: PageHeader, default: RolesForm},
  //       props: { header: {title:'افزودن سطح دسترسی جدید'} },
  //       meta: {
  //         title: "پرتال شرکت - سطح دسترسی جدید"
  //       },
  //     },
  //     {
  //       path: ':id',
  //       name: 'client-role-edit',
  //       components: {header: PageHeader, default: RolesForm},
  //       props: { header: {title:'ویرایش سطح دسترسی'} },
  //       meta: {
  //         title: "پرتال شرکت - سطح دسترسی"
  //       },
  //     },
  //   ]
  // },
  {
    path: 'work-times',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'client-work-times',
        components: {header: PageHeader, default: WorkTimesList},
        props: { header: {title:'لیست شیفت کاری'} },
        meta: {
          title: "پرتال شرکت - شیفت کاری"
        },
      },
      {
        path: 'new',
        name: 'client-work-times-new',
        components: {header: PageHeader, default: WorkTimesForm},
        props: { header: {title:'افزودن شیفت جدید'} },
        meta: {
          title: "پرتال شرکت - شیفت کاری جدید"
        },
      },
      {
        path: ':id',
        name: 'client-work-times-edit',
        components: {header: PageHeader, default: WorkTimesForm},
        props: { header: {title:'ویرایش شیفت کاری'} },
        meta: {
          title: "پرتال شرکت - شیفت کاری"
        },
      },
    ]
  }
];
