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
        Schema::create('baibao_keyword', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('baibao_id');
            $table->unsignedBigInteger('keyword_id');
            $table->timestamps();

            $table->foreign('baibao_id')->references('id')->on('bai_bao_khoa_hocs')->onDelete('cascade');
            $table->foreign('keyword_id')->references('id')->on('keywords')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baibao_keyword');
    }
};
