<?php
/**
 * This file is part of Notadd.
 *
 * @datetime DummyDatetime
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateTopicsTable.
 */
class CreateTopicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('topics', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index();
            $table->string('title')->index();
            $table->text('body');
            $table->unsignedInteger('last_reply_user_id')->default(0)->index();
            $table->text('body_original')->nullable();
            $table->string('type', 16)->default('topic')->index()->comment('内容类型 topic话题 article文章');
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
        $this->schema->dropIfExists('topics');
    }
}
