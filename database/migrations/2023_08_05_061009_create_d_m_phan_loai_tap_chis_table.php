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
        Schema::create('d_m_phan_loai_tap_chis', function (Blueprint $table) {
            //WoS, Scopus, ..
            $table->id();
            $table->string('name')->unique();
            $table->string('fullname')->nullable();
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
        Schema::dropIfExists('d_m_phan_loai_tap_chis');
    }
};
