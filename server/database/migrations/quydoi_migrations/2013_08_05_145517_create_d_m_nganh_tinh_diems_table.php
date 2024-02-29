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
        Schema::create('d_m_nganh_tinh_diems', function (Blueprint $table) {
            $table->id();
            $table->string('manganhtinhdiem')->unique();
            $table->string('tennganhtinhdiem')->nullable();
            $table->string('tennganh_en')->nullable();
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
        Schema::dropIfExists('d_m_nganh_tinh_diems');
    }
};
