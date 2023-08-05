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
        Schema::create('quy_doi_diems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_tacgia');
            $table->foreign('id_tacgia')->references('id')->on('users')->onDelete('cascade');

            $table->string('title');
            $table->string('maso')->nullable();
            $table->string('loaisanpham');
            $table->string('capcongnhan');

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
        Schema::dropIfExists('quy_doi_diems');
    }
};
