<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNotVideoUrl1ToTbttContentTable extends Migration {
    private $dbName = 'tbtt_content';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table($this->dbName, function(Blueprint $table)
        {
            $table->string('not_video_url1')->after('not_video_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table($this->dbName, function(Blueprint $table)
        {
            $table->dropColumn('not_video_url1');
        });
    }

}