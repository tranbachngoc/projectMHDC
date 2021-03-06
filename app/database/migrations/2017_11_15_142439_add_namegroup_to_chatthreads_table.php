<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNamegroupToChatthreadsTable extends Migration
{
    private $dbName = 'chatthreads';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         Schema::table($this->dbName, function(Blueprint $table) {
            $table->string('namegroup')->nullable();
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
            $table->dropColumn('namegroup');
        });
    }
}
