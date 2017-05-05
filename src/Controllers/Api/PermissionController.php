<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-04 20:22
 */
namespace Notadd\Member\Controllers\Api;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Member\Handlers\Permission\GetHandler;

/**
 * Class PermissionController.
 */
class PermissionController extends Controller
{
    /**
     * @param \Notadd\Member\Handlers\Permission\GetHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function get(GetHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
