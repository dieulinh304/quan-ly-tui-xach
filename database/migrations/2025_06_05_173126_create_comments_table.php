<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('sanpham_id');
            $table->text('content');
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id_nd')
                ->on('nguoidung')
                ->onDelete('cascade');

            $table->foreign('sanpham_id')
                ->references('id_sanpham')
                ->on('sanpham')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
