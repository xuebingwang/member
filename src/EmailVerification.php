<?php
/**
 * This file is part of Notadd.
 *
 * @author        Qiyueshiyi <qiyueshiyi@outlook.com>
 * @copyright (c) 2017, iBenchu.org
 * @datetime      2017-04-18 17:27
 */

namespace Notadd\Member;

use Carbon\Carbon;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Str;
use Illuminate\Database\Connection;
use Notadd\Member\Mail\VerificationTokenGenerated;
use Notadd\Member\Models\Member;

class EmailVerification
{
    /**
     * @var \Illuminate\Mail\Mailer
     */
    protected $mailer;

    /**
     * @var \Illuminate\Database\Connection
     */
    protected $db;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $token;


    public function __construct(Mailer $mailer, Connection $db, $table = 'email_verifications')
    {
        $this->db     = $db;
        $this->table  = $table;
        $this->mailer = $mailer;
    }

    /**
     * @param string $storedToken
     * @param string $requestToken
     *
     * @return bool
     */
    public function verifyToken($storedToken, $requestToken)
    {
        return $storedToken == $requestToken;
    }

    public function generate($user)
    {
        if (empty($user->email)) {
            throw new \Exception('The given user instance has an empty or null email field.');
        }

        return $this->saveToken($user, $this->token = $this->generateToken());
    }

    /**
     * @return string
     */
    protected function generateToken()
    {
        return hash_hmac('sha256', Str::random(40), config('app.key'));
    }

    protected function saveToken($user, $token)
    {
        try {
            $this->table()->insert([
                'email'      => $user->email,
                'token'      => $token,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } catch (\Exception $e) {
            $this->table()
                ->where('email', $user->email)
                ->update([
                    'token'      => $token,
                    'updated_at' => Carbon::now(),
                ]);
        }

        $user->is_activated = 'no';

        return $user->save();
    }

    public function send($user, $subject = null, $from = null, $name = null)
    {
        return $this->mailer
            ->to($user->email)
            ->send(new VerificationTokenGenerated($user, $this->token, $subject, $from, $name));
    }

    public function process($email, $token)
    {
        $user = Member::where('email', $email)->first();
        $this->isActivated($user);

        $verifyModel = $this->findEmailVerificationByEmail($email);
        if (! $verifyModel) {
            throw new \Exception('Not Found');
        }

        $this->verifyToken($verifyModel->token, $token);

        $this->wasActivated($user);
    }

    protected function findEmailVerificationByEmail($email)
    {
        return $this->table()->where('email', $email)->first();
    }

    protected function isActivated($user)
    {
        if (! $user || 'yes' === $user->is_activated) {
            throw new \Exception('This user is already verified.');
        }
    }

    protected function wasActivated($user)
    {
        $user->is_activated = 'yes';
        $user->save();

        $this->table()->where('email', $user->email)->delete();
    }

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function table()
    {
        return $this->db->table($this->table);
    }
}
