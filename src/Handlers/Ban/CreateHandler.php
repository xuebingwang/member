<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
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
        $this->validate($this->request, [
            'ip' => 'required|regex:/^(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])\.(\d{1,2}|1\d\d|2[0-4]\d|25[0-5])$/',
        ], [
            'ip.required' => $this->translator->trans('必须填写封禁 IP ！'),
            'ip.regex'    => $this->translator->trans('必须填写正确格式的 IP 地址！'),
        ]);
        $builder = MemberBanIp::query();
        if ($builder->where('ip', $this->request->input('ip'))->count()) {
            $this->errors->push($this->translator->trans('IP 已经存在，不必重复添加'));

            return false;
        }
        if (MemberBanIp::query()->create($this->request->all())) {
            $this->messages->push($this->translator->trans('添加封禁 IP 成功！'));

            return true;
        } else {
            $this->errors->push($this->translator->trans('添加封禁 IP 失败！'));

            return false;
        }
    }
}
