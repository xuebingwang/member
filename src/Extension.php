<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-14 13:49
 */
namespace Notadd\Member;

use Notadd\Foundation\Extension\Abstracts\ExtensionRegistrar;
use Notadd\Foundation\Member\MemberManagement;
use Notadd\Member\Listeners\RouteRegistrar;

/**
 * Class Extension.
 */
class Extension extends ExtensionRegistrar
{
    /**
     * Info for extension.
     *
     * @return array
     */
    public function getExtensionInfo()
    {
        return [
            'author'      => 'twilroad <269044570@qq.com>',
            'description' => 'A module for Notadd',
        ];
    }

    /**
     * Name for extension.
     *
     * @return string
     */
    public function getExtensionName()
    {
        return 'notadd/member';
    }

    /**
     * Path for extension.
     *
     * @return string
     */
    public function getExtensionPath()
    {
        return realpath(__DIR__ . '/../');
    }

    /**
     * Extension's register.
     *
     * @param \Notadd\Foundation\Member\MemberManagement $management
     */
    public function register(MemberManagement $management)
    {
        $manager = new Manager($this->container['events'], $this->container['router']);
        $management->registerManager($manager);
        $this->events->subscribe(RouteRegistrar::class);
    }
}
