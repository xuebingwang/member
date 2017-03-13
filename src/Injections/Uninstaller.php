<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-03-10 14:12
 */
namespace Notadd\Member\Injections;

use Notadd\Foundation\Module\Abstracts\Uninstaller as AbstractUninstaller;

/**
 * Class Uninstaller.
 */
class Uninstaller extends AbstractUninstaller
{
    /**
     * @return mixed
     */
    public function handle()
    {
        return true;
    }

    /**
     * @return mixed
     */
    public function require ()
    {
        return true;
    }
}
