<?php
/**
 * This file is part of Notadd.
 *
 * @datetime 2017-2-7 19:02
 */

use Illuminate\Database\Schema\Blueprint;
use Notadd\Foundation\Database\Migrations\Migration;

/**
 * Class CreateActionPointsTable.
 */
class CreateActionPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->schema->create('action_points', function (Blueprint $table) {
            $table->increments('id');
            $table->string('display_name')->nullable()->comment('操作的显示名称');
            $table->string('name')->unique()->comment('操作的别称 唯一');
            $table->float('points', 8, 2)->default(0)->comment('分值');
            $table->string('description')->nullable()->comment('描述');
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
        $this->schema->dropIfExists('action_points');
    }
}
