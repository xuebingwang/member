<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-05-02 11:24:46
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateMemberBanIpsTable.
 */
class CreateMemberBanIpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('member_ban_ips', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamp('end')->nullable();
            $table->string('ip');
            $table->string('reason')->nullable();
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
        $this->schema->drop('member_ban_ips');
    }
}
