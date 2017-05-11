<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-05-04 18:18:15
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateMemberInformationsTable.
 */
class CreateMemberInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('member_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description')->nullable();
            $table->tinyInteger('details')->default(0);
            $table->tinyInteger('length')->default(0);
            $table->string('name');
            $table->tinyInteger('order')->default(0);
            $table->string('opinions')->nullable();
            $table->tinyInteger('privacy')->default(0);
            $table->tinyInteger('register')->default(0);
            $table->tinyInteger('required')->default(0);
            $table->enum('type', [
                'checkbox',
                'dropdown',
                'file',
                'input',
                'radio',
                'select',
                'textarea',
            ]);
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
        $this->schema->drop('member_informations');
    }
}
