import PageHeader from '../template/components/portal/PageHeader.vue';
import PortalBody from '../template/components/Body.vue';

import UsersList from '../template/views/portal/users/Users.vue';
import UsersForm from '../template/views/portal/users/Users-Form.vue';
import UserLogs from '../template/views/portal/access/User-Logs.vue';

import RoleList from '../template/views/portal/access/Roles.vue';
import RolesForm from '../template/views/portal/access/Roles-Form.vue';

import WorkTimesList from '../template/views/portal/access/WorkTimes.vue';
import WorkTimesForm from '../template/views/portal/access/WorkTimes-Form.vue';

export default [
  {
    path: 'users',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-users',
        components: {header: PageHeader, default: UsersList},
        props: { header: {title:'لیست پرسنل'} },
        meta: {
          title: "پرتال مدیریت - پرسنل"
        },
      },
      {
        path: 'new',
        name: 'portal-user-new',
        components: {header: PageHeader, default: UsersForm},
        props: { header: {title:'افزودن پرسنل جدید'} },
        meta: {
          title: "پرتال مدیریت - پرسنل جدید"
        },
      },
      {
        path: 'edit/:id',
        name: 'portal-user-edit',
        components: {header: PageHeader, default: UsersForm},
        props: { header: {title:'ویرایش پرسنل'} },
        meta: {
          title: "پرتال مدیریت - ویرایش پرسنل"
        },
      },
      {
        path: 'logs',
        name: 'portal-users-logs',
        components: {header: PageHeader, default: UserLogs},
        props: { header: {title:'تاریخچه پرسنل'} },
        meta: {
          title: "پرتال مدیریت - تاریخچه پرسنل"
        },
      },
      {
        path: 'logs/:id',
        name: 'portal-user-logs',
        components: {header: PageHeader, default: UserLogs},
        props: { header: {title:'تاریخچه پرسنل'} },
        meta: {
          title: "پرتال مدیریت - تاریخچه پرسنل"
        },
      },
    ]
  },
  {
    path: 'roles',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-roles',
        components: {header: PageHeader, default: RoleList},
        props: { header: {title:'لیست سطوح دسترسی'} },
        meta: {
          title: "پرتال مدیریت - سطوح دسترسی"
        },
      },
      {
        path: 'new',
        name: 'portal-role-new',
        components: {header: PageHeader, default: RolesForm},
        props: { header: {title:'افزودن سطح دسترسی جدید'} },
        meta: {
          title: "پرتال مدیریت - سطح دسترسی جدید"
        },
      },
      {
        path: ':id',
        name: 'portal-role-edit',
        components: {header: PageHeader, default: RolesForm},
        props: { header: {title:'ویرایش سطح دسترسی'} },
        meta: {
          title: "پرتال مدیریت - سطح دسترسی"
        },
      },
    ]
  },
  {
    path: 'work-times',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-work-times',
        components: {header: PageHeader, default: WorkTimesList},
        props: { header: {title:'لیست شیفت کاری'} },
        meta: {
          title: "پرتال مدیریت - شیفت کاری"
        },
      },
      {
        path: 'new',
        name: 'portal-work-times-new',
        components: {header: PageHeader, default: WorkTimesForm},
        props: { header: {title:'افزودن شیفت جدید'} },
        meta: {
          title: "پرتال مدیریت - شیفت کاری جدید"
        },
      },
      {
        path: ':id',
        name: 'portal-work-times-edit',
        components: {header: PageHeader, default: WorkTimesForm},
        props: { header: {title:'ویرایش شیفت کاری'} },
        meta: {
          title: "پرتال مدیریت - شیفت کاری"
        },
      },
    ]
  }
];
