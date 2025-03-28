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
        Schema::create('d_m_chuyen_mons', function (Blueprint $table) {
            //Chuyên môn được đào tạo: LLPPDH BMVL; Sinh học; ...
            $table->id();
            $table->string('machuyenmon')->unique();
            $table->string('tenchuyenmon')->nullable();
            $table->string('tenchuyenmon_en')->nullable();

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
        Schema::dropIfExists('d_m_chuyen_mons');
    }
};
