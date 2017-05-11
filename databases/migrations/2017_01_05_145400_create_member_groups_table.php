<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-2-7 19:02
 */
use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateGroupsTable.
 */
class CreateGroupsTable extends Migration
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
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('identification')->nullable();
            $table->string('name', 100)->unique()->index();
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
        $this->schema->dropIfExists('member_groups');
    }
}
