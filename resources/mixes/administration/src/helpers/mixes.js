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
      path: '/content',
      component: ContentLayout,
      children: [
        {
          path: '/',
          component: ContentDashboard,
          beforeEnter: router.auth
        }
      ]
    })
  }
}
export function vueMixin (Core, Vue) {
  Core.http = Vue.http
}