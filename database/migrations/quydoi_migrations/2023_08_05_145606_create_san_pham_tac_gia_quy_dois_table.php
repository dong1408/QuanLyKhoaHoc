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
        Schema::create('san_pham_tac_gia_quy_dois', function (Blueprint $table) {
            $table->id();
            //Sản phẩm của tác giả nào?
            $table->unsignedBigInteger('id_sanphamtacgia');
            $table->foreign('id_sanphamtacgia')->references('id')->on('san_pham_tac_gias')->onDelete('cascade');
            //Quy đổi năm nào
            $table->string('namquydoi');
            //Tính điểm theo Hội đồng GSNN ngành nào, chuyên ngành nào của Hội đồng
            $table->unsignedBigInteger('id_nganhtinhdiem');
            $table->foreign('id_nganhtinhdiem')->references('id')->on('d_m_nganh_tinh_diems')->onDelete('cascade');
            $table->unsignedBigInteger('id_chuyennganhtinhdiem')->nullable();
            $table->foreign('id_chuyennganhtinhdiem')->references('id')->on('d_m_chuyen_nganh_tinh_diems')->onDelete('cascade');
            //Mục đích quy đổi là gì
            $table->unsignedBigInteger('id_mucdichquydoi')->nullable();
            $table->foreign('id_mucdichquydoi')->references('id')->on('d_m_muc_dich_quy_dois')->onDelete('cascade');
            //Ai là người tính lần 1, kết quả thế nào?
            $table->unsignedBigInteger('id_nguoiquydoilan1')->nullable();
            $table->foreign('id_nguoiquydoilan1')->references('id')->on('users')->onDelete('cascade');
            //Ai là người tính lần 2, kết quả thế nào?
            $table->unsignedBigInteger('id_nguoiquydoilan2')->nullable();
            $table->foreign('id_nguoiquydoilan2')->references('id')->on('users')->onDelete('cascade');
            //Chốt lại tính ra bao nhiêu giờ, bao nhiêu điểm, ai chốt?
            $table->string('diem')->nullable();
            $table->string('gioquydoi')->nullable();
            $table->string('ngaychot')->nullable();
            $table->unsignedBigInteger('id_nguoichot')->nullable();
            $table->foreign('id_nguoichot')->references('id')->on('users')->onDelete('cascade');

            //Trạng thái quy đổi (chưa thực hiện/đang thực hiện/đã xong)
            $table->string('status')->nullable();
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
        Schema::dropIfExists('san_pham_tac_gia_quy_dois');
    }
};
