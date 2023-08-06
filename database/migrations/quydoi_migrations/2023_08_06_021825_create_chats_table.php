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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            //Đang chat về sản phẩm của tác giả nào nào
            $table->unsignedBigInteger('id_sanphamtacgiaquydoi');
            $table->foreign('id_sanphamtacgiaquydoi')->references('id')->on('san_pham_tac_gia_quy_dois')->onDelete('cascade');
            //Ai là người chat nội dung này
            $table->unsignedBigInteger('id_author');
            $table->foreign('id_author')->references('id')->on('users')->onDelete('cascade');
            //Tiêu đề chat là gì
            $table->string('tieude');
            //Nội dung chat là gì
            $table->string('noidung');
            //File đính kèm
            $table->string('files');
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
        Schema::dropIfExists('chats');
    }
};
