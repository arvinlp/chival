import store from '../store'
import PageHeader from '../template/components/portal/PageHeader.vue';
import PortalBody from '../template/components/portal/Body.vue';
import Portal from '../template/views/portal/Dashboard.vue';
import LoginPortal from '../template/views/Auth/LoginPortal.vue'
import LogoutPortal from '../template/views/Auth/LogoutPortal.vue'

import UserRoutes from '../portal/users-route'

import CompaniesRoutes from '../portal/companies-route'

import BasicRoutes from '../portal/basic-route'

const router = [
  {
    path: '/portal/login',
    name: 'login_portal',
    component: LoginPortal,
    meta: { 
      guestOnly: true
    }
  },
  {
    path: '/portal/logout',
    name: 'logout_portal',
    component: LogoutPortal,
    beforeEach: (to, from, next) => {
      if(store.getters.isType == "admin"){
        next()
      }else{
        next({
          path: '/portal/login',
          query: { redirect: to.fullPath }
        })
      }
    },
    meta: { 
      requiresAuth: true
    }
  },
  {
    path: '/portal',
    component:PortalBody,
    title: 'Portal',
    beforeEach: (to, from, next) => {
      if(store.getters.isType == "admin"){
        next()
      }else{
        next({
          path: '/portal/login',
          query: { redirect: to.fullPath }
        })
      }
    },
    children: [
      {
        path: '/',
        name: 'portal-dashboard',
        components: {header: PageHeader, default: Portal},
        props: { header: {title:'داشبورد'} },
        meta: {
          title: "پرتال مدیریت - داشبورد"
        },
      },
      ...UserRoutes,
      ...CompaniesRoutes,
      ...BasicRoutes
    ],
  },
];
export default router
