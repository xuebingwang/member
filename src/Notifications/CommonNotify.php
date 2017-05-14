<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-14 13:43
 */
namespace Notadd\Member\Notifications;

use Illuminate\Notifications\Notification;

/**
 * Class CommonNotify.
 */
class CommonNotify extends Notification
{
    /**
     * @var array
     */
    protected $data;

    /**
     * CommonNotify constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [
            'database',
        ];
    }
}
