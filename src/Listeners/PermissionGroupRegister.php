<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-26 11:28
 */
namespace Notadd\Member\Listeners;

use Notadd\Foundation\Permission\Abstracts\PermissionGroupRegister as AbstractPermissionGroupRegister;

/**
 * Class PermissionGroupRegister.
 */
class PermissionGroupRegister extends AbstractPermissionGroupRegister
{
    /**
     * Handle Permission Group Register.
     */
    public function handle()
    {
        $this->manager->group('mall', [
            'description'    => '用户中心权限定义。',
            'identification' => 'member',
            'name'           => '用户中心权限',
        ]);
    }
}
