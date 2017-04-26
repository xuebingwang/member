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
     * @return bool
     */
    public function execute()
    {
        if ($this->model->newQuery()->create($this->request->all())) {
            $this->messages->push($this->translator->trans('创建用户组成功！'));

            return true;
        }
        $this->errors->push($this->translator->trans('创建用户失败！'));

        return false;
    }
}
