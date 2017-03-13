<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-09 11:20
 */
namespace Notadd\Member\Listeners;

use Notadd\Member\Events\CheckIn;
use Notadd\Member\Models\Registration;
use Notadd\Member\Events\PublishedTopic;
use Notadd\Member\Models\GetPointsRecord;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Class UserMetadataUpdater.
 */
class UserMetadataUpdater
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(PublishedTopic::class, [$this, 'publishedTopic']);
        $events->listen(CheckIn::class, [$this, 'checkIn']);
    }

    public function publishedTopic(PublishedTopic $event)
    {
        $topicPoints = app('points')->get('public-topic');
        $user = $event->user;
        if ($topicPoints && $topicPoints->exists && $user) {
            $user->points += $topicPoints->points;
            $user->save();
            GetPointsRecord::create([
                'user_id'             => $user->id,
                'action_display_name' => $topicPoints->display_name,
                'action_name'         => $topicPoints->name,
                'points'              => $topicPoints->points,
            ]);
        }
    }

    public function checkIn(CheckIn $event)
    {
        $user = $event->user;
        if (!$user) {
            return;
        }
        if ($user->todaySigned()) {
            return;
        }
        $signAction = app('points')->get('sign');
        if (!$signAction) {
            return;
        }
        Registration::checkIn($user->id, $signAction->points);
        $user->points += $signAction->points;
        $user->total_registration_count += 1;
        if ($user->yesterdaySigned()) {
            $user->continue_registration_count += 1;
        } else {
            $user->continue_registration_count = 1;
        }
        $user->save();
        GetPointsRecord::create([
            'user_id'             => $user->id,
            'action_display_name' => $signAction->display_name,
            'action_name'         => $signAction->name,
            'points'              => $signAction->points,
        ]);
    }
}
