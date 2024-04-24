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
        Schema::create('san_phams', function (Blueprint $table) {
            $table->id();
            $table->string('tensanpham');
            $table->unsignedBigInteger('id_loaisanpham');
            $table->foreign('id_loaisanpham')->references('id')->on('d_m_san_phams')->onDelete('cascade');
            $table->integer('tongsotacgia')->default(0);
            $table->integer('solandaquydoi')->nullable()->default(0);
            //Có sử dụng mail trường không
            $table->boolean('cosudungemailtruong')->nullable()->default(0);
            //Có sử dụng mail đơn vị khác không
            $table->boolean('cosudungemaildonvikhac')->nullable()->default(0);
            //Có thông tin nơi công tác Trường Đại học Sài Gòn không
            $table->boolean('cothongtintruong')->nullable()->default(0);
            //Có thông tin nơi công tác đơn vị khác không, nơi nào
            $table->boolean('cothongtindonvikhac')->nullable()->default(0);
            $table->unsignedBigInteger('id_thongtinnoikhac')->nullable();
            $table->foreign('id_thongtinnoikhac')->references('id')->on('d_m_to_chucs')->onDelete('cascade');
            //Có nhận tài trợ không
            $table->boolean('conhantaitro')->nullable()->default(0);
            $table->unsignedBigInteger('id_donvitaitro')->nullable();
            $table->foreign('id_donvitaitro')->references('id')->on('d_m_to_chucs')->onDelete('cascade');
            $table->string('chitietdonvitaitro')->nullable();
            //Thông tin kê khai
            $table->string('ngaykekhai');
            $table->unsignedBigInteger('id_nguoikekhai');
            $table->foreign('id_nguoikekhai')->references('id')->on('users')->onDelete('cascade');
            //Thông tin trạng thái rà soát (Đang rà soát/Đã xác nhận)
            $table->string('trangthairasoat');
            $table->string('ngayrasoat')->nullable();
            $table->unsignedBigInteger('id_nguoirasoat')->nullable();
            $table->foreign('id_nguoirasoat')->references('id')->on('users')->onDelete('cascade');
            $table->string('diemquydoi')->nullable();
            $table->string('gioquydoi')->nullable();

            //Năm 2023, cần 2 trường thông tin dưới đây để import cho dễ
            //Sau này GV nhập chi tiết rồi
            $table->string('thongtinchitiet')->nullable();
            $table->string('capsanpham')->nullable();
            $table->string('thoidiemcongbohoanthanh')->nullable();

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
        Schema::dropIfExists('san_phams');
    }
};
