<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 17:52
 */
namespace Notadd\Member\Handlers\Group;

use Illuminate\Container\Container;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberGroup;

/**
 * Class EditHandler.
 */
class EditHandler extends Handler
{
    /**
     * @var int
     */
    protected $id;

    /**
     * EditHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->id = 0;
    }

    /**
     * @throws \Exception
     */
    public function configurations()
    {
        $this->id = $this->request->input('id') ?: $this->id;
        if (!$this->id) {
            throw new \Exception('Id is not setted!');
        }
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    public function execute()
    {
        $this->validate($this->request, [
            'identification' => 'required|unique:member_groups,identification,' . $this->request->input('id') . '.id',
            'name'           => 'required',
        ], [
            'identification.required' => $this->translator->trans('必须填写用户组标识！'),
            'identification.unique'   => $this->translator->trans('用户标识必须唯一！'),
            'name.required'           => $this->translator->trans('必须填写用户组名称！'),
        ]);
        $this->configurations();
        $group = MemberGroup::query()->find($this->id);
        if ($group && $group->update($this->request->all())) {
            $this->withCode(200)->withMessage('用户组件编辑成功！');
        } else {
            $this->withCode(500)->withError('Member is not exists!');
        }
    }
}
