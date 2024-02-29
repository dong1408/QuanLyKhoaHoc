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
        Schema::create('tinh_diem_nha_xuat_bans', function (Blueprint $table) {
            $table->id();
            //Nhà xuất bản nào
            $table->unsignedBigInteger('id_nxb');
            $table->foreign('id_nxb')->references('id')->on('nha_xuat_bans')->onDelete('cascade');
            //Tính vào năm nào
            $table->string('namtinhdiem')->nullable();
            //Xét theo Hội đồng ngành nào
            $table->unsignedBigInteger('id_nganhtinhdiem');
            $table->foreign('id_nganhtinhdiem')->references('id')->on('d_m_nganh_tinh_diems')->onDelete('cascade');
            //Chuyên ngành nào của Hội đồng
            $table->unsignedBigInteger('id_chuyennganhtinhdiem');
            $table->foreign('id_chuyennganhtinhdiem')->references('id')->on('d_m_chuyen_nganh_tinh_diems')->onDelete('cascade');
            //Được tính mấy điểm
            $table->string('diem')->nullable();
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
        Schema::dropIfExists('tinh_diem_nha_xuat_bans');
    }
};
