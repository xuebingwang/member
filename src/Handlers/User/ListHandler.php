<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 15:18
 */
namespace Notadd\Member\Handlers\User;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Member\Models\Member;

/**
 * Class ListHandler.
 */
class ListHandler extends DataHandler
{
    /**
     * ListHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Member\Models\Member    $member
     */
    public function __construct(Container $container, Member $member)
    {
        parent::__construct($container);
        $this->model = $member;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function data()
    {
        return $this->model->newQuery()->orderBy('created', 'desc')->paginate(20);
    }
}
