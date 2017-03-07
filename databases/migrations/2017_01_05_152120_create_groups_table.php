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
        $this->schema->create('groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100)->unique()->index();
            $table->string('display_name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        $this->schema->create('group_member', function (Blueprint $table) {
            $table->unsignedInteger('member_id');
            $table->unsignedInteger('group_id');
            $table->primary([
                'member_id',
                'group_id'
            ]);
        });

        $this->schema->create('group_permission', function (Blueprint $table) {
            $table->unsignedInteger('group_id');
            $table->unsignedInteger('permission_id');
            $table->primary([
                'group_id',
                'permission_id'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->schema->dropIfExists('group_permission');
        $this->schema->dropIfExists('group_member');
        $this->schema->dropIfExists('groups');
    }
}
