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
        Schema::create('d_m_noi_cong_tacs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('fullname')->nullable();
            $table->string('eng_name')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('id_address_city')->nullable();
            $table->unsignedBigInteger('id_address_country')->nullable();
            $table->string('website')->nullable();
            $table->string('dienthoai')->nullable();
            $table->unsignedBigInteger('id_phanloainoicongtac')->nullable();
            $table->foreign('id_phanloainoicongtac')->references('id')->on('d_m_phan_loai_noi_cong_tacs')->onDelete('cascade');
            $table->foreign('id_address_city')->references('id')->on('d_m_tinh_thanhs')->onDelete('cascade');
            $table->foreign('id_address_country')->references('id')->on('d_m_quoc_gias')->onDelete('cascade');
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
        Schema::dropIfExists('d_m_noi_cong_tacs');
    }
};
