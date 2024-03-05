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
        Schema::create('d_m_chuyen_nganh_tinh_diems', function (Blueprint $table) {
            $table->id();
            //Thuộc về Hội đồng ngành nào
            $table->unsignedBigInteger('id_nganhtinhdiem')->nullable();
            $table->foreign('id_nganhtinhdiem')->references('id')->on('d_m_nganh_tinh_diems')->onDelete('cascade');
            //Chuyên ngành nào
            $table->string('machuyennganh')->unique();
            $table->string('tenchuyennganh')->nullable();
            $table->string('tenchuyennganh_en')->nullable();

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
        Schema::dropIfExists('d_m_chuyen_nganh_tinh_diems');
    }
};
