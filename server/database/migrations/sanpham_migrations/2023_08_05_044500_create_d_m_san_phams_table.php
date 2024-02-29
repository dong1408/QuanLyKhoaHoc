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
        Schema::create('d_m_san_phams', function (Blueprint $table) {
            //Bài báo khoa học; Báo cáo khoa học; Đề tài; ...
            $table->id();
            $table->string('masanpham')->unique();
            $table->string('tensanpham')->unique();
            $table->string('mota')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_m_san_phams');
    }
};
