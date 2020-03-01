<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLatlngToTbttUserTable extends Migration
{
    private $dbName = 'tbtt_user';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table($this->dbName, function(Blueprint $table) {
            $table->string('use_lat');
            $table->string('use_lng');
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
            $table->dropColumn('use_lat');
            $table->dropColumn('use_lng');
        });
    }
}
