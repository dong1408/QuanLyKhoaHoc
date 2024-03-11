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
        Schema::create('d_m_tinh_thanhs', function (Blueprint $table) {
            $table->id();
            //Thuộc về Quốc gia nào
            $table->unsignedBigInteger('id_quocgia')->nullable();
            $table->foreign('id_quocgia')->references('id')->on('d_m_quoc_gias')->onDelete('cascade');
            //Ký hiệu thành phố
            $table->string('matinhthanh');
            //Tên Tiếng Việt và tên Tiếng Anh
            $table->string('tentinhthanh')->nullable();
            $table->string('tentinhthanh_en')->nullable();

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
        Schema::dropIfExists('d_m_tinh_thanhs');
    }
};
