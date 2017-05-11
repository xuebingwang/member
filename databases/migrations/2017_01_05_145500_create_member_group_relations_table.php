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
class CreateMemberGroupRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('member_group_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('end')->nullable();
            $table->integer('group_id');
            $table->integer('member_id');
            $table->enum('type', ['default', 'extend'])->default('default');
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
        $this->schema->drop('member_group_relations');
    }
}
