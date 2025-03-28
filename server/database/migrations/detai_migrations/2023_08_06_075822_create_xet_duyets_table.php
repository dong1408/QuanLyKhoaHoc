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
        Schema::create('xet_duyets', function (Blueprint $table) {
            $table->id();
            //Đề tài nào
            $table->unsignedBigInteger('id_sanpham');
            $table->foreign('id_sanpham')->references('id')->on('san_phams')->onDelete('cascade');
            //Thông tin xét duyệt
            $table->string('ngayxetduyet');
            $table->string('ketquaxetduyet');
            $table->string('sohopdong')->nullable();
            $table->string('ngaykyhopdong')->nullable();
            $table->integer('thoihanhopdong')->nullable();
            $table->string('kinhphi')->nullable();

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
        Schema::dropIfExists('xet_duyets');
    }
};
