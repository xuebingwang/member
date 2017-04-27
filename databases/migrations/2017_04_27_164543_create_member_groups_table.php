<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-04-27 16:45:43
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateMemberGroupsTable.
 */
class CreateMemberGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('member_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('end')->nullable();
            $table->json('extends')->nullable();
            $table->integer('group_id');
            $table->integer('member_id');
            $table->integer('next');
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
        $this->schema->drop('member_groups');
    }
}
