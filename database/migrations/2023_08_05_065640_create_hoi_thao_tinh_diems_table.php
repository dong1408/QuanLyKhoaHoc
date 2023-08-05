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
        Schema::create('hoi_thao_tinh_diems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_hoithao');
            $table->foreign('id_hoithao')->references('id')->on('hoi_thao_khoa_hocs')->onDelete('cascade');
            $table->unsignedBigInteger('id_nganhtinhdiem');
            $table->foreign('id_nganhtinhdiem')->references('id')->on('d_m_nganh_tinh_diems')->onDelete('cascade');
            $table->unsignedBigInteger('id_chuyennganhtinhdiem');
            $table->foreign('id_chuyennganhtinhdiem')->references('id')->on('d_m_chuyen_nganh_tinh_diems')->onDelete('cascade');
            $table->string('diem')->nullable();
            $table->string('cancu')->nullable();
            $table->string('hieuluc')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('hoi_thao_tinh_diems');
    }
};
