export default function (injection) {
    injection.useSidebar('member', [
        {
            children: [
                {
                    path: '/member/user',
                    title: '用户列表',
                },
                {
                    path: '/member/tag',
                    title: '用户标签',
                },
            ],
            icon: 'plus',
            title: '用户管理',
        },
        {
            children: [
                {
                    path: '/member/information',
                    title: '信息列表',
                },
                {
                    path: '/member/information/group',
                    title: '信息分组',
                },
            ],
            icon: 'plus',
            title: '用户资料',
        },
        {
            children: [
                {
                    path: '/member/ban',
                    title: '封禁用户',
                },
                {
                    path: '/member/ban/ip',
                    title: '封禁IP',
                },
            ],
            icon: 'plus',
            title: '封禁管理',
        },
        {
            children: [
                {
                    path: '/member/group',
                    title: '用户组列表',
                },
                {
                    path: '/member/group/permission',
                    title: '用户组权限',
                },
            ],
            icon: 'plus',
            title: '用户组管理',
        },
        {
            children: [
                {
                    path: '/member/notification',
                    title: '消息列表',
                },
                {
                    path: '/member/notification/create',
                    title: '群发消息',
                },
            ],
            icon: 'plus',
            title: '消息管理',
        },
    ]);
}