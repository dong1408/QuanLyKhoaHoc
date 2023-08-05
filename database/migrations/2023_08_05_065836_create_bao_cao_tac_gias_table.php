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
        Schema::create('bao_cao_tac_gias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_baocao');
            $table->foreign('id_baocao')->references('id')->on('bao_cao_khoa_hocs')->onDelete('cascade');
            $table->unsignedBigInteger('id_tacgia');
            $table->foreign('id_tacgia')->references('id')->on('users')->onDelete('cascade');
            $table->string('vaitrotacgia')->nullable();
            $table->string('thutu')->nullable();
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
        Schema::dropIfExists('bao_cao_tac_gias');
    }
};
