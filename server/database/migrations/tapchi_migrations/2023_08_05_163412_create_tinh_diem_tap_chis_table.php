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
        Schema::create('tinh_diem_tap_chis', function (Blueprint $table) {
            $table->id();
            //Tạp chí nào
            $table->unsignedBigInteger('id_tapchi');
            $table->foreign('id_tapchi')->references('id')->on('tap_chis')->onDelete('cascade');
            //Xét theo Hội đồng ngành nào
            $table->unsignedBigInteger('id_nganhtinhdiem');
            $table->foreign('id_nganhtinhdiem')->references('id')->on('d_m_nganh_tinh_diems')->onDelete('cascade');
            //Chuyên ngành nào của Hội đồng
            $table->unsignedBigInteger('id_chuyennganhtinhdiem');
            $table->foreign('id_chuyennganhtinhdiem')->references('id')->on('d_m_chuyen_nganh_tinh_diems')->onDelete('cascade');
            //Được tính mấy điểm
            $table->string('diem')->nullable();
            //Điểm bắt đầu được tính từ năm nào
            $table->string('namtinhdiem')->nullable();
            //Ai cập nhật thông tin này
            $table->unsignedBigInteger('id_nguoicapnhat')->nullable();
            $table->foreign('id_nguoicapnhat')->references('id')->on('users')->onDelete('cascade');
            //Ghi chú
            $table->string('ghichu')->nullable();

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
        Schema::dropIfExists('tinh_diem_tap_chis');
    }
};
