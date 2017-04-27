<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 16:38
 */
namespace Notadd\Member\Handlers\User;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Member\Models\Member;

/**
 * Class UserHandler.
 */
class UserHandler extends DataHandler
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
     * @param \Notadd\Member\Models\Member    $member
     */
    public function __construct(Container $container, Member $member)
    {
        parent::__construct($container);
        $this->format = 'raw';
        $this->id = 1;
        $this->model = $member;
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
        $builder = $this->model->newQuery();
        $builder = $builder->where('id', $this->id);
        if ($withs = $this->request->input('with')) {
            foreach ((array)$withs as $with) {
                $builder = $builder->with($with);
            }
        }

        return $builder->first();
    }
}
