<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-08 18:17
 */
namespace Notadd\Member\Handlers\Notification;

use Illuminate\Container\Container;
use Illuminate\Notifications\DatabaseNotification;
use Notadd\Foundation\Passport\Abstracts\DataHandler;

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
     * @param \Illuminate\Container\Container   $container
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

    public function data()
    {
        $this->configurations();
        $builder = DatabaseNotification::query();
        if ($withs = $this->request->input('with', [])) {
            foreach ((array)$withs as $with) {
                $builder = $builder->with($with);
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
        if ($this->pagination) {
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
        } else {
            return $response;
        }
    }
}
