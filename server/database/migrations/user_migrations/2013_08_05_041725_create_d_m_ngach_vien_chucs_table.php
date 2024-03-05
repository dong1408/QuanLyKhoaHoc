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
        Schema::create('d_m_ngach_vien_chucs', function (Blueprint $table) {
            $table->id();
            $table->string('mangach')->unique();
            $table->string('tenngach')->nullable();
            $table->string('tenngach_en')->nullable();

            $table->softDeletes();
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
        Schema::dropIfExists('d_m_ngach_vien_chucs');
    }
};
