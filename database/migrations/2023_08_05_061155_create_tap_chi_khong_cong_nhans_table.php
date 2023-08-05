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
        Schema::create('tap_chi_khong_cong_nhans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tapchi');
            $table->boolean('khongduoccongnhan')->nullable();
            $table->boolean('hieuluc')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_tapchi')->references('id')->on('d_m_tap_chis')->onDelete('cascade');
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
        Schema::dropIfExists('tap_chi_khong_cong_nhans');
    }
};
