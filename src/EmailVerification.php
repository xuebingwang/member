<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-04-18 17:27
 */

namespace Notadd\Member;

use Illuminate\Support\Str;
use Illuminate\Database\Connection;

class EmailVerification
{
    /**
     * @var \Illuminate\Database\Connection
     */
    protected $db;

    /**
     * @var string
     */
    protected $table;


    public function __construct(Connection $db, $table = 'email_verifications')
    {
        $this->db    = $db;
        $this->table = $table;
    }

    /**
     * @return string
     */
    protected function generateToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    /**
     * @param string $storedToken
     * @param string $requestToken
     *
     * @return bool
     */
    protected function verifyToken($storedToken, $requestToken)
    {
        return $storedToken == $requestToken;
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table()
    {
        return $this->db->table($this->table);
    }
}
