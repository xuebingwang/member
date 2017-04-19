export default function (injection) {
    injection.useSidebar('member', [
        {
            icon: 'plus',
            path: '/member/user',
            title: '用户管理',
        },
        {
            icon: 'plus',
            path: '/member/information',
            title: '用户资料',
        },
        {
            icon: 'plus',
            path: '/member/group',
            title: '用户组管理',
        },
        {
            icon: 'plus',
            path: '/member/security',
            title: '安全管理',
        },
    ]);
}
