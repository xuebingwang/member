<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-01-23 16:26
 */

namespace Notadd\Member\Controllers\Admin;

use Illuminate\Http\Request;
use Notadd\Member\Models\ActionPoints;
use Notadd\Member\Abstracts\AbstractAdminController;

class ActionPointsController extends AbstractAdminController
{
    public function index()
    {
        $query = ActionPoints::query();

        $lists = $query->paginate(20);

        return $this->view('user.action-points.index', compact('lists'));
    }

    public function create()
    {
        $actionPoints = new ActionPoints;

        return $this->view('user.action-points.create', compact('actionPoints'));
    }

    public function store(Request $request)
    {
        $actionPoints = ActionPoints::addAction(
            $request->offsetGet('name'),
            $request->offsetGet('points'),
            $request->offsetGet('display_name'),
            $request->offsetGet('description')
        );

        return redirect()->to('admin/user/action_points');
    }

    public function edit($id)
    {
        $actionPoints = ActionPoints::findOrFail($id);

        return $this->view('user.action-points.update', compact('actionPoints'));
    }

    public function update(Request $request, $id)
    {
        $actionPoints = ActionPoints::findOrFail($id);

        $actionPoints->fill(array_only($request->all(), ['display_name', 'points', 'description']));

        $actionPoints->save();

        return redirect()->to('admin/user/action_points');
    }

    public function destroy($id)
    {
        $actionPoints = ActionPoints::findOrFail($id);

        $actionPoints->delete();

        return redirect()->to('admin/user/action_points');
    }
}
