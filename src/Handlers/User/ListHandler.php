<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-04-21 15:18
 */
namespace Notadd\Member\Handlers\User;

use Illuminate\Container\Container;
use Notadd\Foundation\Passport\Abstracts\DataHandler;
use Notadd\Member\Models\Member;
use Notadd\Member\Models\MemberGroup;

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
     * @param \Notadd\Member\Models\Member    $member
     */
    public function __construct(Container $container, Member $member)
    {
        parent::__construct($container);
        $this->format = 'raw';
        $this->model = $member;
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
        if ($withs = $this->request->input('with', [])) {
            foreach ((array)$withs as $with) {
                $builder = $builder->with($with);
            }
        }
        if ($this->request->has('search')) {
            $builder = $builder->where('name', 'like', "%{$this->request->input('search')}%");
        }
        $this->pagination = $builder->orderBy($this->order, $this->sort)->paginate($this->paginate);
        $data = [];
        switch ($this->format) {
            case 'raw':
                $data = $this->pagination->items();
                break;
            case 'beauty':
                $data = $this->format($this->pagination->items());
                break;
        }

        return $data;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    public function format(array $data)
    {
        return collect($data)->transform(function (Member $member) {
            switch ($member->getAttribute('status')) {
                case 'normal':
                    $member->setAttribute('status', '正常');
                    break;
            }
            $groups = collect($member->getAttribute('groups'));
            if ($groups->count()) {
                $groups->each(function (MemberGroup $group) use ($member) {
                    if ($group->getAttribute('type') === 'default') {
                        $details = $group->details()->getResults();
                        $member->setAttribute('group', $details->name);
                    }
                });
            } else {
                $member->setAttribute('group', '默认分组');
            }

            return $member;
        })->toArray();
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
