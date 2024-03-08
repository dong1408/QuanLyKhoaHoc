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
        Schema::create('tap_chi_d_m_phan_loai_tap_chi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tapchi');
            $table->foreign('id_tapchi')->references('id')->on('tap_chis')->onDelete('cascade');
            $table->unsignedBigInteger('id_dmphanloaitapchi');
            $table->foreign('id_dmphanloaitapchi')->references('id')->on('d_m_phan_loai_tap_chi')->onDelete('cascade');

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
        Schema::dropIfExists('tap_chi_d_m_phan_loai_tap_chi');
    }
};
