<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-26 17:15
 */
namespace Notadd\Member\Handlers\Group;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberGroup;

/**
 * Class RemoveHandler.
 */
class RemoveHandler extends SetHandler
{
    /**
     * RemoveHandler constructor.
     *
     * @param \Illuminate\Container\Container   $container
     * @param \Notadd\Member\Models\MemberGroup $group
     */
    public function __construct(Container $container, MemberGroup $group)
    {
        parent::__construct($container);
        $this->model = $group;
    }

    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        $group = $this->model->newQuery()->find($this->request->input('id'));
        if ($group) {
            $group->delete();
            $this->messages->push($this->translator->trans('删除用户组成功！'));

            return true;
        }
        $this->errors->push($this->translator->trans('删除用户组失败！'));

        return false;
    }
}
