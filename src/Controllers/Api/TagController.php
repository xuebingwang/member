<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 18:22
 */
namespace Notadd\Member\Controllers\Api;

use Notadd\Foundation\Routing\Abstracts\Controller;
use Notadd\Member\Handlers\Tag\CreateHandler;
use Notadd\Member\Handlers\Tag\EditHandler;
use Notadd\Member\Handlers\Tag\ListHandler;
use Notadd\Member\Handlers\Tag\PatchHandler;
use Notadd\Member\Handlers\Tag\RelationHandler;
use Notadd\Member\Handlers\Tag\TagHandler;
use Notadd\Member\Handlers\Tag\UserHandler;

/**
 * Class TagController.
 */
class TagController extends Controller
{
    /**
     * @param \Notadd\Member\Handlers\Tag\CreateHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function create(CreateHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Member\Handlers\Tag\EditHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function edit(EditHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Member\Handlers\Tag\ListHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function list(ListHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Member\Handlers\Tag\PatchHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function patch(PatchHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Member\Handlers\Tag\RelationHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function relation(RelationHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Member\Handlers\Tag\TagHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function tag(TagHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }

    /**
     * @param \Notadd\Member\Handlers\Tag\UserHandler $handler
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse|\Psr\Http\Message\ResponseInterface|\Zend\Diactoros\Response
     */
    public function user(UserHandler $handler)
    {
        return $handler->toResponse()->generateHttpResponse();
    }
}
