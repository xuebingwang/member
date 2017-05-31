<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <heshudong@ibenchu.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-02 11:30
 */
namespace Notadd\Member\Handlers\Ban;

use Notadd\Foundation\Routing\Abstracts\Handler;
use Notadd\Member\Models\MemberBanIp;

/**
 * Class CreateHandler.
 */
class CreateHandler extends Handler
{
    /**
     * Execute Handler.
     *
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
            $this->withCode(500)->withError('IP 已经存在，不必重复添加');
        } else {
            if (MemberBanIp::query()->create($this->request->all())) {
                $this->withCode(200)->withMessage('添加封禁 IP 成功！');
            } else {
                $this->withCode(500)->withError('添加封禁 IP 失败！');
            }
        }
    }
}
