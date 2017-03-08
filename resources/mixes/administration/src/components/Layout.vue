<script>
  import Core from '../main'
  export default {
    beforeCreate: function () {
      this.$options.components.LayoutContent = Core.instance.layouts.content
      this.$options.components.LayoutFooter = Core.instance.layouts.footer
      this.$options.components.LayoutSidebar = Core.instance.layouts.sidebar
      this.$options.components.NavbarMenu = Core.instance.components.navbar
      this.$options.components.SidebarMenu = Core.instance.components.sidebar
    },
    data: () => {
      return {
        nav: [
          {
            text: '用户管理',
            icon: 'fa fa-file-o',
            uri: '/member/user'
          },
          {
            text: '用户组管理',
            icon: 'fa fa-file-o',
            uri: '/member/group'
          },
          {
            text: '安全管理',
            icon: 'fa fa-file-o',
            uri: '/member/security'
          }
        ]
      }
    }
  }
</script>
<template>
    <div>
        <layout-sidebar>
            <sidebar-menu :menu="nav"></sidebar-menu>
        </layout-sidebar>
        <layout-content>
            <router-view></router-view>
        </layout-content>
        <layout-footer></layout-footer>
    </div>
</template>