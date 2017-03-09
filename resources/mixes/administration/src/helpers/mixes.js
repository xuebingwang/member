import Dashboard from '../components/Dashboard'
import Group from '../components/Group'
import Layout from '../components/Layout'
import Security from '../components/Security'
import User from '../components/User'
export function headerMixin (Core) {
  Core.header = function (menu) {
    menu.push({
      'text': '用户中心',
      'icon': 'icon icon-article',
      'uri': '/member'
    })
  }
}
export function installMixin (Core) {
  Core.install = function (Vue, Notadd) {
    Core.instance = Notadd
    vueMixin(Core, Vue)
  }
}
export function routerMixin (Core) {
  Core.router = function (router) {
    router.modules.push({
      path: '/member',
      component: Layout,
      children: [
        {
          path: '/',
          component: Dashboard,
          beforeEnter: router.auth
        },
        {
          path: 'group',
          component: Group,
          beforeEnter: router.auth
        },
        {
          path: 'security',
          component: Security,
          beforeEnter: router.auth
        },
        {
          path: 'user',
          component: User,
          beforeEnter: router.auth
        }
      ]
    })
  }
}
export function vueMixin (Core, Vue) {
  Core.http = Vue.http
}