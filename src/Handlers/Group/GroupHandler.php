<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 17:32
 */
namespace Notadd\Member\Handlers\Group;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\Handler;
use Notadd\Member\Models\MemberGroup;

/**
 * Class GroupHandler.
 */
class GroupHandler extends Handler
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var int
     */
    protected $id;

    /**
     * UserHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->format = 'raw';
        $this->id = 1;
    }

    /**
     * @throws \Exception
     */
    public function configurations()
    {
        $this->format = $this->request->input('format') ?: $this->format;
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
    protected function execute()
    {
        $this->configurations();
        $this->success()->withData(MemberGroup::query()->find($this->id))->withMessage('获取分组成功！');
    }
}
