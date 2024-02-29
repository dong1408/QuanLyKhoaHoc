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
        Schema::create('tap_chi_d_m_nganh_theo_hdgs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tapchi');
            $table->foreign('id_tapchi')->references('id')->on('tap_chis')->onDelete('cascade');
            $table->unsignedBigInteger('id_dmnganhtheohdgs');
            $table->foreign('id_dmnganhtheohdgs')->references('id')->on('d_m_nganh_theo_hdgs')->onDelete('cascade');
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
        Schema::dropIfExists('tap_chi_d_m_nganh_theo_hdgs');
    }
};
