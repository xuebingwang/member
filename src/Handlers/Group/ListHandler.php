<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 17:42
 */
namespace Notadd\Member\Handlers\Group;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Member\Models\Group;

/**
 * Class ListHandler.
 */
class ListHandler extends DataHandler
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
     * @param \Notadd\Member\Models\Group     $group
     */
    public function __construct(Container $container, Group $group)
    {
        parent::__construct($container);
        $this->format = 'raw';
        $this->model = $group;
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
     * @return array
     */
    public function data()
    {
        $this->configurations();
        $builder = $this->model->newQuery();
        if ($without = $this->request->input('without')) {
            if (is_array($without)) {
                $builder = $builder->whereNotIn('id', $without);
            } else {
                $builder = $builder->where('id', '!=', $without);
            }
        }
        $this->pagination = $builder->orderBy($this->order, $this->sort)->paginate($this->paginate);

        return $this->pagination->items();
    }

    /**
     * Make data to response with errors or messages.
     *
     * @return \Notadd\Foundation\Passport\Responses\ApiResponse
     * @throws \Exception
     */
    public function toResponse()
    {
        $response = parent::toResponse();

        return $response->withParams([
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
