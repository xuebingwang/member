<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-04-29 14:52:58
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateMemberActivatesTable.
 */
class CreateMemberActivatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('member_activates', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('activated')->default(0);
            $table->text('context')->nullable();
            $table->integer('member_id');
            $table->string('type')->default('')->nullable();
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
        $this->schema->drop('member_activates');
    }
}
