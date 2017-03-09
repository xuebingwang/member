<?php
/**
 * Created by PhpStorm.
 * User: twilroad
 * Date: 2017/3/9
 * Time: 下午7:27
 */
namespace Notadd\Member\Injections;

use Notadd\Foundation\Module\Abstracts\Installer as AbstractInstaller;

/**
 * Class Installer.
 */
class Installer extends AbstractInstaller
{

    /**
     * @return bool
     */
    public function handle()
    {
        return true;
    }

    /**
     * @return bool
     */
    public function require ()
    {
        return true;
    }
}
