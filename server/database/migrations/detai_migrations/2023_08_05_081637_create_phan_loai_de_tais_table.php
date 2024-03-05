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
        Schema::create('phan_loai_de_tais', function (Blueprint $table) {
            $table->id();
            $table->string('maloai')->nullable();
            $table->string('tenloai')->unique();
            $table->string('kinhphi')->nullable();
            $table->text('mota')->nullable();

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
        Schema::dropIfExists('phan_loai_de_tais');
    }
};
