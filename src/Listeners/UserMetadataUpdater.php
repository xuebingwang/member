<?php
/**
 * This file is part of Notadd.
 *
 * @author Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-02-09 11:20
 */
namespace Notadd\Member\Listeners;

use Notadd\Member\Models\Registration;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class UserMetadataUpdater.
 */
class UserMetadataUpdater
{
    /**
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
    }
}
