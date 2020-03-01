<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatthreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('chatthreads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['private', 'group','public']);
            $table->integer('ownerId');
            $table->integer('requesterId');
            $table->string('alias');
            $table->timestamp('createdAt')->nullable();
            $table->timestamp('updatedAt')->nullable();

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
        Schema::dropIfExists('chatthreads');
    }
}
