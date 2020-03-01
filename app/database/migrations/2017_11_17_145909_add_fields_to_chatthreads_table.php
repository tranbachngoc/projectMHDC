<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToChatthreadsTable extends Migration
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
            $table->boolean('isStreaming')->default(false);
            $table->integer('virtualId');
            $table->dateTime('lastStreamingTime');
            $table->integer('streamingTime');
            $table->text('avatar');
            $table->integer('typechat');


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

    }
}
