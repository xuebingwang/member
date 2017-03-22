<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-17 17:33
 */
namespace Notadd\Member\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class AdminPermission.
 */
class AdminPermission extends Permission
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
        if ($this->auth->guard($guard)->guest() || ! $request->user($guard)->adminMay(explode('|', $permissions))) {
            if ($this->wantsJson()) {
                return new JsonResponse([
                    'code'    => 403,
                    'data'    => [],
                    'message' => '你没有权限执行此操作.',
                ], 403);
            }

            abort(403, '你没有权限执行此操作.');
        }

        return $next($request);
    }
}
