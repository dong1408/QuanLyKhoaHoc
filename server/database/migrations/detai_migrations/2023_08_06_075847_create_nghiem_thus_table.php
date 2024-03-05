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
        Schema::create('nghiem_thus', function (Blueprint $table) {
            $table->id();
            //Đề tài nào
            $table->unsignedBigInteger('id_sanpham');
            $table->foreign('id_sanpham')->references('id')->on('san_phams')->onDelete('cascade');
            //Thông tin nghiệm thu
            $table->string('hoidongnghiemthu')->nullable();
            $table->string('ngaynghiemthu')->nullable();
            $table->string('ketquanghiemthu')->nullable();
            $table->string('ngaycongnhanhoanthanh')->nullable();
            $table->string('soqdcongnhanhoanthanh')->nullable();
            $table->string('thoigiangiahan')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('nghiem_thus');
    }
};
