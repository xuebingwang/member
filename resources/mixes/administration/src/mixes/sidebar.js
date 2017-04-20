export default function (injection) {
    injection.useSidebar('member', [
        {
            icon: 'plus',
            path: '/member/user',
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
            title: '封禁',
        },
        {
            icon: 'plus',
            path: '/member/group',
            title: '用户组管理',
        },
        {
            icon: 'plus',
            path: '/member/tag',
            title: '用户标签',
        },
        {
            icon: 'plus',
            path: '/member/security',
            title: '安全管理',
        },
    ]);
}
