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
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->string('tensanpham');
            $table->unsignedBigInteger('id_loaisanpham');
            $table->foreign('id_loaisanpham')->references('id')->on('d_m_san_phams')->onDelete('cascade');
            $table->integer('tongsotacgia')->default(0);
            $table->integer('solandaquydoi')->default(0);
            $table->string('thoidiemdaquydoi')->nullable();
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
        Schema::dropIfExists('san_phams');
    }
};
