<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-01-22 17:41
 */

return [
    // 前台权限
    'frontend' => [
        [
            'name'         => 'create-user',
            'display_name' => '添加用户',
            'description'  => '添加用户',
        ],
    ],
    // 后台权限
    'admin' => [
        [
            'name'         => 'create-user',
            'display_name' => '后台添加用户',
            'description'  => '后台添加用户',
        ],
        [
            'name'         => 'update-user',
            'display_name' => '后台编辑用户',
            'description'  => '后台编辑用户',
        ],
        [
            'name'         => 'delete-user',
            'display_name' => '后台删除用户',
            'description'  => '后台删除用户',
        ],
        [
            'name'         => 'create-group',
            'display_name' => '后台添加角色',
            'description'  => '后台添加角色',
        ],
        [
            'name'         => 'update-group',
            'display_name' => '后台编辑角色',
            'description'  => '后台编辑角色',
        ],
        [
            'name'         => 'delete-group',
            'display_name' => '后台删除角色',
            'description'  => '后台删除角色',
        ],
    ],
];
 