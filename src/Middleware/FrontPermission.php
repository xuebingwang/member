<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-03-10 15:22
 */

namespace Notadd\Member\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class FrontPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure                  $next
     * @param                           $permissions
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $permissions, $guard = null)
    {
        if ($this->auth->guard($guard)->guest() || ! $request->user($guard)->frontMay(explode('|', $permissions))) {
            if ($this->wantsJson()) {
                return new JsonResponse('Forbidden', 403);
            }

            abort(403);
        }

        return $next($request);
    }
}
