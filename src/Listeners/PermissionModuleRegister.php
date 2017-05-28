<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-27 18:19
 */
namespace Notadd\Member\Listeners;

use Notadd\Foundation\Permission\Abstracts\PermissionModuleRegister as AbstractPermissionModuleRegister;

/**
 * Class PermissionModuleRegister.
 */
class PermissionModuleRegister extends AbstractPermissionModuleRegister
{
    /**
     * Handle Permission Register.
     */
    public function handle()
    {
        $this->manager->extend([
            'description'    => '用户中心权限。',
            'identification' => 'member',
            'name'           => '用户中心',
        ]);
    }
}