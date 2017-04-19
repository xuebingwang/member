<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-2-7 19:02
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateEmailVerificationsTable.
 */
class CreateEmailVerificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('email_verifications', function (Blueprint $table) {
            $table->string('email', 100)->unique();
            $table->string('token')->nullable();
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
        $this->schema->dropIfExists('email_verifications');
    }
}
