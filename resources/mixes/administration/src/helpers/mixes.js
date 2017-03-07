import Dashboard from '../components/Dashboard'
import Layout from '../components/Layout'
export function headerMixin (Core) {
  Core.header = function (menu) {
    menu.push({
      'text': '用户中心',
      'icon': 'icon icon-article',
      'uri': '/content'
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
        }
      ]
    })
  }
}
export function vueMixin (Core, Vue) {
  Core.http = Vue.http
}