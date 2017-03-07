<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-2-7 19:02
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateNotificationsTable.
 */
class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sender_id')->unsigned()->index()->comment('操作人 如: 点赞的人');
            $table->integer('user_id')->unsigned()->index()->comment('文章等所属的用户');
            $table->integer('subject_id')->unsigned()->index()->comment('文章等, 被点赞人点赞的文章等');
            $table->string('subject_type', 100)->index()->comment('主题的类型, 如 文章 帖子等');
            $table->integer('reply_id')->unsigned()->nullable()->index()->comment('回复');
            $table->text('body')->nullable();
            $table->string('type', 100)->index()->comment('at@别人 like点赞 new_reply有一个新回复');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('notifications');
    }
}
