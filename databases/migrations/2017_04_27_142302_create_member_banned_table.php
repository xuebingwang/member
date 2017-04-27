<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-04-27 14:23:02
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateMemberBannedTable.
 */
class CreateMemberBannedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('member_banned', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('end')->nullable();
            $table->integer('member_id');
            $table->string('reason')->nullable();
            $table->tinyInteger('type')->default(0);
            $table->tinyInteger('time')->default(0);
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
        $this->schema->drop('member_banned');
    }
}
