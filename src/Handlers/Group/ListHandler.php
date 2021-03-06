<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-04-21 17:42
 */
namespace Notadd\Member\Handlers\Group;

use Illuminate\Container\Container;
use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberGroup;

/**
 * Class ListHandler.
 */
class ListHandler extends Handler
{
    /**
     * @var string
     */
    protected $format;

    /**
     * @var string
     */
    protected $order;

    /**
     * @var int
     */
    protected $paginate;

    /**
     * @var \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    protected $pagination;

    /**
     * @var string
     */
    protected $sort;

    /**
     * ListHandler constructor.
     *
     * @param \Illuminate\Container\Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct($container);
        $this->format = 'raw';
        $this->order = 'created_at';
        $this->paginate = 20;
        $this->sort = 'desc';
    }

    public function configurations()
    {
        $this->format = $this->request->input('format') ?: $this->format;
        $this->order = $this->request->input('order') ?: $this->order;
        $this->paginate = $this->request->input('paginate') ?: $this->paginate;
        $this->sort = $this->request->input('sort') ?: $this->sort;
    }

    /**
     * Execute Handler.
     *
     * @throws \Exception
     */
    protected function execute()
    {
        $this->configurations();
        $builder = MemberGroup::query();
        if ($without = $this->request->input('without')) {
            if (is_array($without)) {
                $builder = $builder->whereNotIn('id', $without);
            } else {
                $builder = $builder->where('id', '!=', $without);
            }
        }
        $this->pagination = $builder->orderBy($this->order, $this->sort)->paginate($this->paginate);
        if ($this->pagination) {
            $this->success()->withData($this->pagination->items())->withMessage('')->withExtra([
                'pagination' => [
                    'count'    => $this->pagination->total(),
                    'current'  => $this->pagination->currentPage(),
                    'from'     => $this->pagination->firstItem(),
                    'next'     => $this->pagination->nextPageUrl(),
                    'paginate' => $this->paginate,
                    'prev'     => $this->pagination->previousPageUrl(),
                    'to'       => $this->pagination->lastItem(),
                    'total'    => $this->pagination->lastPage(),
                ],
            ]);
        }
    }
}
