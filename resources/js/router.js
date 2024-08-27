import Vue from 'vue'
import VueRouter from 'vue-router'
import store from './store'
import PageNotFound from './template/views/PageNotFound.vue'
import PageNotFoundPortal from './template/views/portal/PageNotFound.vue'
import UnauthorizedPage from './template/views/UnauthorizedPage.vue'
import UnauthorizedPagePortal from './template/views/portal/UnauthorizedPage.vue'
import PortalRoutes from './portal/main-route'
import ClientRoutes from './client/main-route'
import PrintTest from './print-test.vue'

Vue.use(VueRouter)

const routers = new VueRouter({
  mode: 'history',
  linkActiveClass: 'active',
  routes: [
    {
      path: '*',
      component: PageNotFound,
      beforeEnter: (to, from, next) => {
        next({path: '/404'})
      },
    },
    {
      path: '/401',
      component: UnauthorizedPage,
      meta:{
        title: "دسترسی شما محدود شده است - chival"
      }
    },
    {
      path: '/403',
      component: UnauthorizedPage,
      meta:{
        title: "دسترسی شما محدود شده است - chival"
      }
    },
    {
      path: '/404',
      component: PageNotFound,
      meta:{
        title: "صفحه مدنظر یافت نشد - chival"
      }
    },
    {
      path: '/500',
      component: PageNotFound,
      meta:{
        title: "صفحه مدنظر یافت نشد - chival"
      }
    },
    {
      path: '/portal/401',
      component: UnauthorizedPagePortal,
      meta:{
        title: "دسترسی شما محدود شده است - chival"
      }
    },
    {
      path: '/portal/403',
      component: UnauthorizedPagePortal,
      meta:{
        title: "دسترسی شما محدود شده است - chival"
      }
    },
    {
      path: '/portal/404',
      component: PageNotFoundPortal,
      meta:{
        title: "صفحه مدنظر یافت نشد - chival"
      }
    },
    {
      path: '/portal/500',
      component: PageNotFoundPortal,
      meta:{
        title: "صفحه مدنظر یافت نشد - chival"
      }
    },
    ...ClientRoutes,
    ...PortalRoutes,
  ]
})
routers.beforeEach((to, from, next) => {
  
  if (to.matched.some(record => record.meta.requiresAuth)) {

    if (!store.getters.isAuthenticated) {
      next({
        path: '/login',
        query: { redirect: to.fullPath }
      })
    } else {
      return next()
    }
  } else {
    next()
  }

  if (to.matched.some(record => record.meta.guestOnly)) {
    
    if (store.getters.isAuthenticated) {    
      next({
        path: '/'
      })
    } else {
      next()
    }
  } else {
    next()
  }
  const nearestWithTitle = to.matched.slice().reverse().find(r => r.meta && r.meta.title);
  // If a route with a title was found, set the document (page) title to that value.
  if(nearestWithTitle) document.title = nearestWithTitle.meta.title;

})
export default routers;
