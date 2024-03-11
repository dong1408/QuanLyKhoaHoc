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
        Schema::create('nha_xuat_ban_khong_cong_nhans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_nxb');
            $table->foreign('id_nxb')->references('id')->on('nha_xuat_bans')->onDelete('cascade');
            $table->boolean('khongduoccongnhan')->nullable();
            $table->string('ghichu')->nullable();
            $table->unsignedBigInteger('id_nguoicapnhat')->nullable();
            $table->foreign('id_nguoicapnhat')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('nha_xuat_ban_khong_cong_nhans');
    }
};
