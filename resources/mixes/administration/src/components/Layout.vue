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
            text: '文章管理',
            icon: 'fa fa-file-text-o',
            uri: '#',
            menu: [
              {
                text: '全部文章',
                uri: '/content/article/all'
              },
              {
                text: '分类管理',
                uri: '/content/article/category'
              },
              {
                text: '回收站',
                icon: 'fa fa-circle-o',
                uri: '/content/article/recycle'
              },
              {
                text: '草稿箱',
                icon: 'fa fa-circle-o',
                uri: '/content/article/draft'
              }/* ,
                 {
                 text: '标签管理',
                 icon: 'fa fa-circle-o',
                 uri: '/content/article/tag'
                 }, */
            ]
          },
          {
            text: '页面管理',
            icon: 'fa fa-file-o',
            uri: '#',
            menu: [
              {
                text: '全部页面',
                icon: 'fa fa-circle-o',
                uri: '/content/page/all'
              },
              {
                text: '分类管理',
                icon: 'fa fa-circle-o',
                uri: '/content/page/category'
              }
            ]
          },
          {
            text: '模块组件',
            icon: 'fa fa-building',
            uri: '#',
            menu: [
              {
                text: 'SEO配置',
                icon: 'fa fa-circle-o',
                uri: '/content/component'
              }
            ]
          }/* ,
             {
             text: '模板管理',
             icon: 'fa fa-circle-o',
             uri: '/content/template'
             },
             {
             text: '插件管理',
             icon: 'fa fa-circle-o',
             uri: '/content/extension'
             },
             {
             text: '评论功能',
             icon: 'fa fa-circle-o',
             uri: '/content/comment'
             } */
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