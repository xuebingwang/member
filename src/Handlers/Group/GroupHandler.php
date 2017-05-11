<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 17:32
 */
namespace Notadd\Member\Handlers\Group;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Member\Models\MemberGroup;

/**
 * Class GroupHandler.
 */
class GroupHandler extends DataHandler
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
     * @param \Illuminate\Container\Container   $container
     * @param \Notadd\Member\Models\MemberGroup $group
     */
    public function __construct(Container $container, MemberGroup $group)
    {
        parent::__construct($container);
        $this->format = 'raw';
        $this->id = 1;
        $this->model = $group;
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
     * @return mixed
     */
    public function data()
    {
        $this->configurations();

        return $this->model->newQuery()->find($this->id);
    }
}
