<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-2-7 19:02
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class UpdateMembersTable.
 */
class UpdateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->table('members', function (Blueprint $table) {
            $table->enum('activated', ['yes', 'no'])->default('no')->comment('邮箱是否激活');
            $table->string('avatar')->nullable()->comment('头像');
            $table->enum('banned', ['yes', 'no'])->default('no')->comment('是否禁止');
            $table->date('birthday')->nullable()->comment('生日');
            $table->string('introduction')->nullable()->comment('自我介绍');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('phone', 20)->nullable()->comment('手机号');
            $table->float('points', 8, 2)->default(0)->comment('积分');
            $table->string('realname')->nullable()->comment('真实姓名');
            $table->tinyInteger('sex')->default(0)->comment('性别 0保密 1男 2女');
            $table->string('signature')->nullable()->comment('签名');
            $table->string('status', 32)->default('normal')->comment('normal正常 banned禁止 deleted删除 activated激活');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->table('members', function (Blueprint $table) {
            $table->dropColumn('activated');
            $table->dropColumn('avatar');
            $table->dropColumn('banned');
            $table->dropColumn('birthday');
            $table->dropColumn('introduction');
            $table->dropColumn('nickname');
            $table->dropColumn('phone');
            $table->dropColumn('points');
            $table->dropColumn('realname');
            $table->dropColumn('sex');
            $table->dropColumn('signature');
            $table->dropColumn('status');
            $table->dropSoftDeletes();
        });
    }
}
