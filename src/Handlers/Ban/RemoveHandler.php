<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-02 11:32
 */
namespace Notadd\Member\Handlers\Ban;

use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberBanIp;

/**
 * Class RemoveHandler.
 */
class RemoveHandler extends SetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        if (!$this->request->has('id')) {
            $this->errors->push($this->translator->trans('参数缺失！'));

            return false;
        }
        $builder = MemberBanIp::query();
        if ($builder->where('id', $this->request->input('id'))->count()) {
            $builder->find($this->request->input('id'))->delete();
            $this->messages->push($this->translator->trans('删除封禁 IP 成功！'));

            return true;
        } else {
            $this->errors->push($this->translator->trans('封禁 IP 不存在！'));

            return false;
        }
    }
}
