<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTbttNotificationsTable extends Migration {
    private $dbName = 'tbtt_notifications';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create($this->dbName, function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('read')->default(false); //only one device active for one user
            $table->integer('userId');
            $table->string('actionType')->nullable();
            $table->integer('actionId')->nullable();
            $table->string('title')->nullable(); 
            $table->string('body')->nullable();
            $table->text('meta')->nullable();
            $table->integer('updatedAt')->nullable();
            $table->integer('createdAt')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop($this->dbName);
    }

}