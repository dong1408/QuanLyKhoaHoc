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
        Schema::create('d_m_vai_tro_tac_gias', function (Blueprint $table) {
            //Chủ nhiệm; Chủ biên; Fist Author; Tác giả liên hệ; Thành viên
            $table->id();
            $table->string('tenvaitro')->unique();
            $table->string('mota')->nullable();
            $table->string('tenvaitro_en')->nullable();
            $table->string('role', 200);
            $table->string('mavaitro')->unique();
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
        Schema::dropIfExists('d_m_vai_tro_tac_gias');
    }
};
