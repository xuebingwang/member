<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-14 13:56
 */
namespace Notadd\Member\Listeners;

use Notadd\Foundation\Routing\Abstracts\RouteRegister as AbstractRouteRegister;
use Notadd\Member\Controllers\MemberController;

/**
 * Class RouteRegistrar.
 */
class RouteRegister extends AbstractRouteRegister
{
    /**
     * Handle Route Registrar.
     */
    public function handle()
    {
        $this->router->group(['middleware' => 'web', 'prefix' => 'member'], function () {
            $this->router->resource('/', MemberController::class);
        });
    }
}
