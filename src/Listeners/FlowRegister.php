<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2017, notadd.com
 * @datetime 2017-05-31 20:44
 */
namespace Notadd\Member\Listeners;

use Notadd\Foundation\Flow\Abstracts\FlowRegister as AbstractFlowRegister;
use Notadd\Member\Entities\Member;
use Notadd\Member\Entities\MemberBan;
use Notadd\Member\Entities\MemberGroup;
use Notadd\Member\Entities\MemberInformation;
use Notadd\Member\Entities\MemberNotification;
use Notadd\Member\Entities\MemberPermission;
use Notadd\Member\Entities\MemberTag;
use Notadd\Member\Entities\MemberVerification;

/**
 * Class FlowRegister.
 */
class FlowRegister extends AbstractFlowRegister
{
    /**
     * Register flow or flows.
     */
    public function handle()
    {
        $this->flow->register(Member::class);
        $this->flow->register(MemberBan::class);
        $this->flow->register(MemberGroup::class);
        $this->flow->register(MemberInformation::class);
        $this->flow->register(MemberNotification::class);
        $this->flow->register(MemberPermission::class);
        $this->flow->register(MemberTag::class);
        $this->flow->register(MemberVerification::class);
    }
}
