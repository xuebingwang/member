<?php
/**
 * This file is part of Notadd.
 *
 * @author        TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime      2016-08-02 14:58
 */
namespace Notadd\Member\Listeners;

use Illuminate\Http\Request;

use Illuminate\Contracts\Events\Dispatcher;
use Notadd\Foundation\Configuration\Repository;
use Illuminate\Contracts\Foundation\Application;
use Notadd\Member\Events\GetAdminMenu as GetAdminMenuEvent;
use Illuminate\Routing\Events\RouteMatched as IsRouteMatched;

/**
 * Class RouteMatched.
 */
class RouteMatched
{
    /**
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * @var \Illuminate\Events\Dispatcher
     */
    protected $events;

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * RouteMatched constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\Config\Repository                $config
     * @param \Illuminate\Contracts\Events\Dispatcher      $events
     * @param \Illuminate\Http\Request                     $request
     */
    public function __construct(Application $app, Repository $config, Dispatcher $events, Request $request)
    {
        $this->app     = $app;
        $this->config  = $config;
        $this->events  = $events;
        $this->request = $request;
    }

    /**
     * @return void
     */
    public function subscribe()
    {
        $this->events->listen(IsRouteMatched::class, [$this, 'handle']);
    }

    /**
     * @return void
     */
    public function handle()
    {
        if ($this->request->is('admin*')) {
            $menu = $this->config->get('admin');
            foreach ($menu as $top_key => $top) {
                if (isset($top['sub'])) {
                    foreach ($top['sub'] as $one_key => $one) {
                        if (isset($one['sub'])) {
                            $active = false;
                            foreach ((array) $one['active'] as $rule) {
                                if ($this->request->is($rule)) {
                                    $active = true;
                                }
                            }
                            if ($active) {
                                $menu[$top_key]['sub'][$one_key]['active'] = 'open';
                            } else {
                                $menu[$top_key]['sub'][$one_key]['active'] = '';
                            }
                            foreach ($one['sub'] as $two_key => $two) {
                                $active = false;
                                foreach ((array) $two['active'] as $rule) {
                                    if ($this->request->is($rule)) {
                                        $active = true;
                                    }
                                }
                                if ($active) {
                                    $menu[$top_key]['sub'][$one_key]['sub'][$two_key]['active'] = 'open';
                                } else {
                                    $menu[$top_key]['sub'][$one_key]['sub'][$two_key]['active'] = '';
                                }
                            }
                        } else {
                            if ($this->request->is($one['active'])) {
                                $menu[$top_key]['sub'][$one_key]['active'] = 'active';
                            } else {
                                $menu[$top_key]['sub'][$one_key]['active'] = '';
                            }
                        }
                    }
                }
            }
            $this->config->set('admin', $menu);
        }
    }
}
