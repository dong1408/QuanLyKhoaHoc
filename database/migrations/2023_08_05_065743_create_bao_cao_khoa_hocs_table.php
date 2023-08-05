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
        Schema::create('bao_cao_khoa_hocs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('abstract')->nullable();
            $table->string('doi')->nullable();
            $table->string('url')->nullable();
            $table->string('keywords')->nullable();
            $table->unsignedBigInteger('id_hoithao');
            $table->string('file')->nullable();
            $table->string('sotacgia')->nullable();
            $table->foreign('id_hoithao')->references('id')->on('hoi_thao_khoa_hocs')->onDelete('cascade');
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
        Schema::dropIfExists('bao_cao_khoa_hocs');
    }
};
