import PageHeader from '../template/components/portal/PageHeader.vue';
import PortalBody from '../template/components/Body.vue';

import CompanyUsersList from '../template/views/portal/companies/users/Users.vue';
import CompanyUsersLogs from '../template/views/portal/companies/users/Users-Logs.vue';
import CompanyUsersForm from '../template/views/portal/companies/users/Users-Form.vue';

export default [
  {
    path: 'companies/:id/users',
    component:PortalBody,
    children: [
      {
        path: '',
        name: 'portal-company-users',
        components: {header: PageHeader, default: CompanyUsersList},
        props: { header: {title:'پرسنل شرکت'} },
        meta: {
          title: "پرتال مدیریت - پرسنل شرکت"
        },
      },
      {
        path: 'new',
        name: 'portal-company-user-new',
        components: {header: PageHeader, default: CompanyUsersForm},
        props: { header: {title:'افزودن پرسنل جدید'} },
        meta: {
          title: "پرتال مدیریت - پرسنل جدید"
        },
      },
      {
        path: 'edit/:uid',
        name: 'portal-company-user-edit',
        components: {header: PageHeader, default: CompanyUsersForm},
        props: { header: {title:'ویرایش پرسنل'} },
        meta: {
          title: "پرتال مدیریت - ویرایش پرسنل"
        },
      },
      {
        path: 'logs',
        name: 'portal-company-users-logs',
        components: {header: PageHeader, default: CompanyUsersLogs},
        props: { header: {title:'تاریخچه پرسنل'} },
        meta: {
          title: "پرتال مدیریت - تاریخچه پرسنل"
        },
      },
      {
        path: 'logs/:uid',
        name: 'portal-company-user-logs',
        components: {header: PageHeader, default: CompanyUsersLogs},
        props: { header: {title:'تاریخچه پرسنل'} },
        meta: {
          title: "پرتال مدیریت - تاریخچه پرسنل"
        },
      },
    ]
  },
];
