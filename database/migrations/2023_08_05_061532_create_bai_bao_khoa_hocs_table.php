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
        Schema::create('bai_bao_khoa_hocs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('abstract')->nullable();
            $table->string('doi')->nullable();
            $table->string('url')->nullable();
            $table->string('keywords')->nullable();
            $table->string('received')->nullable();
            $table->string('accepted')->nullable();
            $table->string('published')->nullable();
            $table->unsignedBigInteger('id_tapchi');
            $table->string('file')->nullable();
            $table->string('sotacgia')->nullable();
            $table->foreign('id_tapchi')->references('id')->on('d_m_tap_chis')->onDelete('cascade');
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
        Schema::dropIfExists('bao_bao_khoa_hocs');
    }
};
