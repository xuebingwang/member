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
            $table->string('phone', 20)->nullable()->comment('手机号');
            $table->string('nick_name')->nullable()->comment('昵称');
            $table->string('real_name')->nullable()->comment('真实姓名');
            $table->tinyInteger('sex')->default(0)->comment('性别 0保密 1男 2女');
            $table->date('birthday')->nullable()->comment('生日');
            $table->string('signature')->nullable()->comment('签名');
            $table->string('introduction')->nullable()->comment('自我介绍');
            $table->string('avatar')->nullable()->comment('头像');
            $table->float('points', 8, 2)->default(0)->comment('积分');
            $table->integer('total_registration_count')->unsigned()->default(0)->index()->comment('用户总的签到天数');
            $table->integer('continue_registration_count')->unsigned()->default(0)->index()->comment('连续签到天数');
            $table->enum('is_banned', ['yes', 'no'])->default('no')->comment('是否禁止');
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
            $table->dropColumn('phone');
            $table->dropColumn('nick_name');
            $table->dropColumn('real_name');
            $table->dropColumn('sex');
            $table->dropColumn('birthday');
            $table->dropColumn('signature');
            $table->dropColumn('introduction');
            $table->dropColumn('avatar');
            $table->dropColumn('points');
            $table->dropColumn('total_registration_count');
            $table->dropColumn('continue_registration_count');
            $table->dropColumn('is_banned');
            $table->dropColumn('deleted_at');
        });
    }
}
