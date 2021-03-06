<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-01-23 11:33
 */
namespace Notadd\Member\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Class Group.
 */
class Group extends AbstractAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Closure                  $next
     * @param                           $groups
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $groups)
    {
        if ($this->auth->guest() || !$request->user()->hasGroup(explode('|', $groups))) {
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

