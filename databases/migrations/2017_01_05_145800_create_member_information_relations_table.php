<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-05-04 18:44:24
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateMemberInformationRelationsTable.
 */
class CreateMemberInformationRelationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('member_information_relations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('group_id');
            $table->integer('information_id');
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
        $this->schema->drop('member_information_relations');
    }
}
