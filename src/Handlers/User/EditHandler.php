<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 17:22
 */
namespace Notadd\Member\Handlers\User;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\Member;

/**
 * Class EditHandler.
 */
class EditHandler extends SetHandler
{
    /**
     * @var int
     */
    protected $id;

    /**
     * EditHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     * @param \Notadd\Member\Models\Member    $member
     */
    public function __construct(Container $container, Member $member)
    {
        parent::__construct($container);
        $this->id = 0;
        $this->model = $member;
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
     * @return bool
     */
    public function execute()
    {
        $this->configurations();
        $member = $this->model->newQuery()->find($this->id);
        if ($member) {
            $member->update($this->request->all());

            return true;
        }
        $this->errors->push($this->translator->trans('Member is not exists!'));

        return false;
    }
}
