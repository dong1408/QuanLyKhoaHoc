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
        Schema::create('d_m_phan_loai_noi_cong_tacs', function (Blueprint $table) {
            //Trường, Viện, Trung tâm, ...
            $table->id();
            $table->string('name')->unique();
            $table->string('eng_name')->nullable();
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
        Schema::dropIfExists('d_m_phan_loai_noi_cong_tacs');
    }
};
