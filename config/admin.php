<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime      2016-08-02 14:55
 */
return [
    'general' => [
        'title'      => '概略导航',
        'active'     => 'admin',
        'permission' => [
            'founder-manage',
        ],
        'sub'        => [
            [
                'title'      => '仪表盘',
                'active'     => 'admin',
                'permission' => [
                    'founder-manage',
                    'shopkeeper-manage',
                    'contact-manage',
                ],
                'url'        => 'admin',
                'icon'       => 'fa-dashboard',
            ],
        ],
    ],
    'group'   => [
        'title'  => '组件导航',
        'active' => '',
        'sub'    => [
            'user-center' => [
                'title'  => '用户中心',
                'icon'   => 'fa-cogs',
                'active' => [
                    'admin/user/users*',
                    'admin/user/groups*',
                    'admin/user/permissions*',
                    'admin/user/action_points*',
                    'admin/topics*',
                ],
                'sub'    => [
                    [
                        'title'  => '用户管理',
                        'icon'   => 'fa-cogs',
                        'active' => 'admin/user/users*',
                        'url'    => 'admin/user/users',
                    ],
                    [
                        'title'  => '用户组管理',
                        'active' => 'admin/user/groups*',
                        'url'    => 'admin/user/groups',
                    ],
                    [
                        'title'  => '角色权限管理',
                        'active' => 'admin/user/permissions*',
                        'url'    => 'admin/user/permissions',
                    ],
                    [
                        'title'  => '行为积分',
                        'active' => 'admin/user/action_points*',
                        'url'    => 'admin/user/action_points',
                    ],
                    [
                        'title'  => '话题管理',
                        'active' => 'admin/topics*',
                        'url'    => 'admin/topics',
                    ],
                ],
            ],
        ],
    ],
];
