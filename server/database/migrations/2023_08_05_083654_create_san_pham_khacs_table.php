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
        Schema::create('san_pham_khacs', function (Blueprint $table) {
            $table->id();
            //Sản phẩm khác nào
            $table->unsignedBigInteger('id_sanpham');
            $table->foreign('id_sanpham')->references('id')->on('san_phams')->onDelete('cascade');
            //Chi tiết về sản phẩm khác
            $table->string('maso')->nullable();
            //Đơn vị nào công nhận
            $table->unsignedBigInteger('id_donvicongnhan')->nullable();
            $table->foreign('id_donvicongnhan')->references('id')->on('d_m_to_chucs')->onDelete('cascade');
            $table->string('capcongnhan');
            $table->string('ngaycongnhan');
            $table->string('ghichu');

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
        Schema::dropIfExists('san_pham_khacs');
    }
};
