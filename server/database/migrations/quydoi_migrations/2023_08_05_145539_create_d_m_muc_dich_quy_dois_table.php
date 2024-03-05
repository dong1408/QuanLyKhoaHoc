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
        Schema::create('d_m_muc_dich_quy_dois', function (Blueprint $table) {
            //Nghĩa vụ; Vượt giờ
            $table->id();
            $table->string('mamucdich')->unique();
            $table->string('tenmucdich')->nullable();

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
        Schema::dropIfExists('d_m_muc_dich_quy_dois');
    }
};
