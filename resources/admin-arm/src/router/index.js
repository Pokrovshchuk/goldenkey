import Vue from 'vue'
import VueRouter from 'vue-router'
import store from '../store/index.js'
import authMiddleware from './middleware/auth.js'
import loggedMiddleware from './middleware/logged.js'
import hallDataMiddleware from './middleware/hallData.js'
import middlewarePipeline from './middlewarePipeline.js'
import Home from '../views/Home.vue'
import Auth from '../views/Auth.vue'
import Certificates from '../views/Certificates.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/admin/arm/',
    name: 'Home',
    component: Home,
    meta: {
      middleware: [hallDataMiddleware, loggedMiddleware, authMiddleware],
    },
  },
  {
    path: '/admin/arm/certificates',
    name: 'Certificates',
    component: Certificates,
    meta: {
      middleware: [loggedMiddleware, hallDataMiddleware, authMiddleware],
    },
  },
  {
    path: '/admin/arm/auth',
    name: 'Auth',
    component: Auth,
    meta: {
      middleware: [authMiddleware, loggedMiddleware, hallDataMiddleware],
    },
  },
  {
    path: '*',
    redirect: '/admin/arm/',
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
})

router.beforeEach((to, from, next) => {
  if (!to.meta.middleware) {
    return next()
  }
  const middleware = to.meta.middleware
  const app = Vue
  const context = {
    to,
    from,
    next,
    store,
    app,
  }
  return middleware[0]({
    ...context,
    next: middlewarePipeline(context, middleware, 1),
  })
})

export default router
