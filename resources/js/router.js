import Router from 'vue-router'

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/Login.vue')
    },
    {
      path: '/purchase',
      name: 'purchase',
      component: () => import('../views/Purchase.vue')
    },
  ]
})