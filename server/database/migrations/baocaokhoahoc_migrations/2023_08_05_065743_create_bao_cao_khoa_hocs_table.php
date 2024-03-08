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
        Schema::create('bao_cao_khoa_hocs', function (Blueprint $table) {
            $table->id();
            //Báo cáo nào
            $table->unsignedBigInteger('id_sanpham');
            $table->foreign('id_sanpham')->references('id')->on('san_phams')->onDelete('cascade');
            //Thông tin chi tiết Báo cáo khoa học
            $table->string('doi')->nullable();
            $table->string('url')->nullable();
            $table->string('received')->nullable();
            $table->string('accepted')->nullable();
            $table->string('published')->nullable();
            $table->string('abstract')->nullable();
            $table->text('keywords')->nullable(); //dài nên để định dạng text
            //Thuộc Hội thảo nào
            $table->unsignedBigInteger('id_hoithao');
            $table->foreign('id_hoithao')->references('id')->on('hoi_thao_khoa_hocs')->onDelete('cascade');
            $table->string('pages')->nullable();

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
        Schema::dropIfExists('bao_cao_khoa_hocs');
    }
};
