<?php
/**
 * Created by PhpStorm.
 * User: twilroad
 * Date: 2017/3/9
 * Time: 下午7:26
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
