<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypedataToChatmessagesTable extends Migration
{
    private $dbName = 'chatmessages';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table($this->dbName, function(Blueprint $table) {
            $table->string('typedata')->default('text');
            $table->integer("userDelete");
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
            $table->dropColumn('typedata');
            $table->dropColumn('userDelete');
        });
    }
}
