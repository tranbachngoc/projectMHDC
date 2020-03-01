<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevicesTable extends Migration {
    private $dbName = 'tbtt_devices';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create($this->dbName, function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['android', 'ios'])->default('android');
            $table->boolean('active')->default(true); //only one device active for one user
            $table->integer('userId')->nullable();
            $table->string('token'); //device token
            $table->string('imei')->nullable(); //device token
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