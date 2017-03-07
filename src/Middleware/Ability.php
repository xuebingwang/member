<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-01-23 11:38
 */

namespace Notadd\Member\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class Ability extends AbstractAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param Closure                  $next
     * @param                          $roles
     * @param                          $permissions
     * @param bool                     $validateAll
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $roles, $permissions, $validateAll = false)
    {
        if ($this->auth->guest() || ! $request->user()->ability(explode('|', $roles), explode('|', $permissions), ['validate_all' => $validateAll])) {

            if ($this->wantsJson()) {
                return new JsonResponse('Forbidden', 403);
            }

            abort(403);
        }

        return $next($request);
    }
}
