<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusReadToChatthreaduserTable extends Migration
{
    private $dbName = 'chatthreaduser';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table($this->dbName, function(Blueprint $table) {
            $table->integer('statusRead')->default(1);
            $table->integer('blocked')->default(0);
            $table->integer('blockedNotify')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table($this->dbName, function($table) {
            $table->dropColumn('statusRead');
            $table->dropColumn('blocked');
            $table->dropColumn('blockedNotify');
        });
    }
}
