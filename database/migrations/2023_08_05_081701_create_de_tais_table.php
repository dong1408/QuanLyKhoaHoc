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
        Schema::create('de_tais', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('maso')->unique();
            $table->string('kinhphi')->nullable();
            $table->string('ngaychapnhan')->nullable();
            $table->string('thoihan')->nullable();
            $table->string('giahan')->nullable();
            $table->string('ngaynghiemthu')->nullable();
            $table->string('xeploai')->nullable();
            $table->string('ngaycongnhanhoanthanh')->nullable();
            $table->string('soqdcongnhanhoanthanh')->nullable();
            $table->string('file')->nullable();
            $table->string('sotacgia')->nullable();
            $table->unsignedBigInteger('id_loaidetai')->nullable();
            $table->foreign('id_loaidetai')->references('id')->on('phan_loai_de_tais')->onDelete('cascade');
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
        Schema::dropIfExists('de_tais');
    }
};
