<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-22 17:41
 */

return [
    // 前台权限
    'front' => [
        [
            'name'         => 'member.user.create',
            'display_name' => '添加用户',
            'description'  => '添加用户',
        ],
    ],
    // 后台权限
    'admin' => [
        [
            'name'         => 'member.user.create',
            'display_name' => '后台添加用户',
            'description'  => '后台添加用户',
        ],
        [
            'name'         => 'member.user.update',
            'display_name' => '后台编辑用户',
            'description'  => '后台编辑用户',
        ],
        [
            'name'         => 'member.user.delete',
            'display_name' => '后台删除用户',
            'description'  => '后台删除用户',
        ],
        [
            'name'         => 'member.group.create',
            'display_name' => '后台添加角色',
            'description'  => '后台添加角色',
        ],
        [
            'name'         => 'member.group.update',
            'display_name' => '后台编辑角色',
            'description'  => '后台编辑角色',
        ],
        [
            'name'         => 'member.group.delete',
            'display_name' => '后台删除角色',
            'description'  => '后台删除角色',
        ],
    ],
];
 