<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatmessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('chatmessages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['private', 'group','public']);
            $table->integer('ownerId');
            $table->integer('threadId');
            $table->text('text');
            $table->integer('messageId');
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
         Schema::dropIfExists('chatmessages');
    }
}
