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
        Schema::create('san_pham_tac_gias', function (Blueprint $table) {
            $table->id();
            //Sản phẩm nào
            $table->unsignedBigInteger('id_sanpham');
            $table->foreign('id_sanpham')->references('id')->on('san_phams')->onDelete('cascade');
            //Tác giả nào
            $table->unsignedBigInteger('id_tacgia');
            $table->foreign('id_tacgia')->references('id')->on('users')->onDelete('cascade');
            //Vai trò tác giả
            $table->unsignedBigInteger('id_vaitrotacgia')->nullable();
            $table->foreign('id_vaitrotacgia')->references('id')->on('d_m_vai_tro_tac_gias')->onDelete('cascade');
            //Thứ tự và tỷ lệ đóng góp (nếu có) của tác giả
            $table->string('thutu')->nullable();
            $table->string('tyledonggop')->nullable();

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
        Schema::dropIfExists('san_pham_tac_gias');
    }
};
