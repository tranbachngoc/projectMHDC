<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersionTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('version', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('version')->default(1);
            $table->string('lastversion')->default(1);
            $table->string('os')->default('android');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('version');
    }

}
