<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-01-13 12:17
 */

return [
    'defaults'  => [
        'guard'     => 'web',
        'passwords' => 'users',
    ],
    'guards'    => [
        'api' => [
            'driver'   => 'passport',
            'provider' => 'users',
        ],
        'web' => [
            'driver'   => 'session',
            'provider' => 'users',
        ],
    ],
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model'  => \Notadd\Member\Models\Member::class,
        ],
    ],
    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table'    => 'password_resets',
            'expire'   => 60,
        ],
    ],
];
