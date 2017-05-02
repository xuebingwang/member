<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime 2017-05-02 11:30
 */
namespace Notadd\Member\Handlers\Ban;

use Notadd\Foundation\Passport\Abstracts\SetHandler;
use Notadd\Member\Models\MemberBanIp;

/**
 * Class CreateHandler.
 */
class CreateHandler extends SetHandler
{
    /**
     * Execute Handler.
     *
     * @return bool
     * @throws \Exception
     */
    public function execute()
    {
        if (MemberBanIp::query()->create($this->request->all())) {
            $this->messages->push($this->translator->trans('添加封禁 IP 成功！'));

            return true;
        } else {
            $this->errors->push($this->translator->trans('添加封禁 IP 失败！'));

            return false;
        }
    }
}
