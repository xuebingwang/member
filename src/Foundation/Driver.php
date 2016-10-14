<?php
/**
 * This file is part of Notadd.
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-10-14 14:56
 */
namespace Notadd\Member\Foundation;
use Notadd\Foundation\Member\Abstracts\Driver as AbstractDriver;
use Notadd\Member\Models\Member;
/**
 * Class Driver
 * @package Notadd\Member\Foundation
 */
class Driver extends AbstractDriver {
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Member\Models\Member
     */
    protected function creating(array $data, $force = false) {
        return new Member();
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Abstracts\Member
     */
    protected function deleting(array $data, $force = false) {
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Abstracts\Member
     */
    protected function editing(array $data, $force = false) {
    }
    /**
     * @param $key
     * @return \Notadd\Foundation\Member\Abstracts\Member
     */
    protected function finding($key) {
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Abstracts\Member
     */
    protected function storing(array $data, $force = false) {
    }
    /**
     * @param array $data
     * @param bool $force
     * @return \Notadd\Foundation\Member\Abstracts\Member
     */
    protected function updating(array $data, $force = false) {
    }
}