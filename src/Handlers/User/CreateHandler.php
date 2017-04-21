<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 17:13
 */
namespace Notadd\Member\Handlers\User;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\Member;

/**
 * Class Create.
 */
class CreateHandler extends SetHandler
{
    /**
     * Create constructor.
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
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute()
    {
        return $this->model->newQuery()->create($this->request->all());
    }
}
