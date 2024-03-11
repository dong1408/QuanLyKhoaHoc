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
        Schema::create('bai_bao_khoa_hocs', function (Blueprint $table) {
            $table->id();
            //Bài báo nào
            $table->unsignedBigInteger('id_sanpham');
            $table->foreign('id_sanpham')->references('id')->on('san_phams')->onDelete('cascade');
            //Thông tin chi tiết bài báo
            $table->string('doi')->nullable();
            $table->string('url')->nullable();
            $table->string('received')->nullable();
            $table->string('accepted')->nullable();
            $table->string('published')->nullable();
            $table->text('abstract')->nullable();
            $table->text('keywords')->nullable(); //dài nên để định dạng text
            //Thuộc tạp chí nào
            $table->unsignedBigInteger('id_tapchi');
            $table->foreign('id_tapchi')->references('id')->on('tap_chis')->onDelete('cascade');
            $table->string('volume')->nullable(); // Tập tạp chí
            $table->string('issue')->nullable();
            $table->string('number')->nullable(); // Số tạp chí
            $table->string('pages')->nullable(); // Các trang của bài viết trong tạp chí
            
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
        Schema::dropIfExists('bao_bao_khoa_hocs');
    }
};
