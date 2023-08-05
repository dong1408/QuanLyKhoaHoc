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
        Schema::create('bai_bao_tac_gias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_baibao');
            $table->foreign('id_baibao')->references('id')->on('bai_bao_khoa_hocs')->onDelete('cascade');
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
        Schema::dropIfExists('bai_bao_tac_gias');
    }
};
