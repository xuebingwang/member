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

/**
 * Class FlowRegister.
 */
class FlowRegister extends AbstractFlowRegister
{
    /**
     * @var array
     */
    protected $definitions = [
    ];

    /**
     * Register flow or flows.
     */
    public function handle()
    {
        foreach ($this->definitions as $definition) {
            if (method_exists($this, 'register' . ucfirst($definition) . 'Flow')) {
                $this->{'register' . ucfirst($definition) . 'Flow'}();
            }
        }
    }
}
