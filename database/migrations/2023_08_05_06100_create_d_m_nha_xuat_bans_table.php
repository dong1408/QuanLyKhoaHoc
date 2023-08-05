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
        Schema::create('d_m_nha_xuat_bans', function (Blueprint $table) {
            $table->id();
            $table->text('name')->unique();
            $table->string('isbn')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('id_address_city')->nullable();
            $table->foreign('id_address_city')->references('id')->on('d_m_tinh_thanhs')->onDelete('cascade');
            $table->unsignedBigInteger('id_address_country')->nullable();
            $table->foreign('id_address_country')->references('id')->on('d_m_quoc_gias')->onDelete('cascade');
            $table->string('website')->nullable();
            $table->string('id_donvichuquan')->nullable();
            $table->foreign('id_donvichuquan')->references('id')->on('d_m_noi_cong_tacs')->onDelete('cascade');
            $table->string('quocte')->nullable();
            $table->string('ngonngu')->nullable();
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
        Schema::dropIfExists('d_m_nha_xuat_bans');
    }
};
