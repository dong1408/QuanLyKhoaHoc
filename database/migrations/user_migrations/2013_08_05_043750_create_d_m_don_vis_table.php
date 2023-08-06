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
        Schema::create('d_m_don_vis', function (Blueprint $table) {
            //Khoa, phòng ban, viện, kí túc xá, trung tâm, trạm y tế, trường tiểu học, ...
            $table->id();
            //Thuộc về Tổ chức nào
            $table->unsignedBigInteger('id_tochuc')->nullable();
            $table->foreign('id_tochuc')->references('id')->on('d_m_to_chucs')->onDelete('cascade');
            //Ký hiệu đơn vị
            $table->string('madonvi')->unique();
            $table->string('tendonvi')->nullable();
            $table->string('tendonvi_en')->nullable();
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
        Schema::dropIfExists('d_m_don_vis');
    }
};
