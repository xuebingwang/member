<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-08 18:24
 */
namespace Notadd\Member\Controllers\Api;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Member\Handlers\Verification\SendHandler;

/**
 * Class VerificationController.
 */
class VerificationController extends Controller
{
    /**
     * @param \Notadd\Member\Handlers\Verification\SendHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function send(SendHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
