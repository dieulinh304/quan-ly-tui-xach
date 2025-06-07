<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nguoidung', function (Blueprint $table) {
            $table->increments('id_nd');
            $table->string('hoten', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('password', 100)->nullable();
            $table->string('diachi')->nullable();
            $table->integer('sdt')->nullable();
            $table->integer('id_phanquyen')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nguoidung');
    }
};
