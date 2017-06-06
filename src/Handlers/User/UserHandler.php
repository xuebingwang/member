<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 16:38
 */
namespace Notadd\Member\Handlers\User;

use Illuminate\Container\Container;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\Member;

/**
 * Class UserHandler.
 */
class UserHandler extends Handler
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
        $builder = Member::query();
        $builder = $builder->where('id', $this->id);
        if ($withs = $this->request->input('with')) {
            foreach ((array)$withs as $with) {
                $builder = $builder->with($with);
            }
        }
        $this->success()->withData($builder->first()->toArray())->withMessage('');
    }
}
