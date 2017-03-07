<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-02-09 10:34
 */

namespace Notadd\Member\Controllers\Admin;

use Illuminate\Http\Request;
use Notadd\Member\Models\Topic;
use Notadd\Member\Events\PublishedTopic;
use Notadd\Member\Abstracts\AbstractAdminController;

class TopicController extends AbstractAdminController
{
    public function index()
    {
        $lists = Topic::with('user')->paginate(30);

        return $this->view('topic.index', compact('lists'));
    }

    public function create()
    {
        $user  = $this->request->user();
        $topic = new Topic([
            'title' => 'Article one',
            'body'  => 'test points',
        ]);
        $user->topics()->save($topic);

        $this->events->fire(new PublishedTopic($user, $topic));

        return redirect()->route('admin.topics.index');

        return $this->view('topic.create', compact('topic'));
    }

    public function store(Request $request)
    {
        $user  = $this->request->user();
        $topic = new Topic(array_only($request->all(), ['title', 'body']));
        $user->topics()->save($topic);

        return redirect('topics');
    }
}
