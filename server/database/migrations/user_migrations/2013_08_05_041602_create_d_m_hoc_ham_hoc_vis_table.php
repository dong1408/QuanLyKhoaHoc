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
        Schema::create('d_m_hoc_ham_hoc_vis', function (Blueprint $table) {
            $table->id();
            $table->string('mahochamhocvi')->unique();
            $table->string('tenhochamhocvi')->nullable();
            $table->string('tenhochamhocvi_en')->nullable();

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
        Schema::dropIfExists('d_m_hoc_ham_hoc_vis');
    }
};
