<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 17:49
 */
namespace Notadd\Member\Handlers\Group;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\Group;

/**
 * Class CreateHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * Create constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Member\Models\Group     $group
     */
    public function __construct(Container $container, Group $group)
    {
        parent::__construct($container);
        $this->model = $group;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function execute()
    {
        return $this->model->newQuery()->create($this->request->all());
    }
}
