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
        Schema::create('hoi_thao_khoa_hocs', function (Blueprint $table) {
            $table->id();
            //Tên Hội thảo
            $table->string('name',500)->unique();
            //Đơn vị tổ chức
            $table->unsignedBigInteger('id_donvitochuc')->nullable();
            $table->foreign('id_donvitochuc')->references('id')->on('d_m_to_chucs')->onDelete('cascade');
            //Địa điểm tổ chức
            $table->string('diadiemtochuc')->nullable();
            $table->unsignedBigInteger('id_diadiemtochuc_city')->nullable();
            $table->foreign('id_diadiemtochuc_city')->references('id')->on('d_m_tinh_thanhs')->onDelete('cascade');
            $table->unsignedBigInteger('id_diadiemtochuc_country')->nullable();
            $table->foreign('id_diadiemtochuc_country')->references('id')->on('d_m_quoc_gias')->onDelete('cascade');
            //Website Hội thảo
            $table->string('website')->nullable();
            //Ngôn ngữ sử dụng
            $table->string('ngonngu')->nullable();
            //Hình thức tổ chức (trực tiếp/Trực tuyến)
            $table->string('hinhthuc')->nullable();
            //Cấp tổ chức Hội thảo (Quốc tế/Quốc Gia/Trường)
            $table->string('caphoithao')->nullable();
            //Có kỷ yếu không, nếu có thì thuộc nhà xuất bản nào
            $table->string('tenkyyeu')->nullable();
            $table->string('thoidiemxuatban')->nullable();
            $table->unsignedBigInteger('id_nhaxuatban')->nullable();
            $table->foreign('id_nhaxuatban')->references('id')->on('nha_xuat_bans')->onDelete('cascade');
            //Kỷ yếu có phản biện không?
            $table->string('phanbien')->nullable();
            //Status, mô tả trạng thái tạp chí đã được phê duyệt
            //Đề phòng Hội thảo do Viên chức thêm vào
            $table->boolean('trangthai')->nullable(); //Đang xem xét; Được chấp thuận
            $table->unsignedBigInteger('id_nguoithem')->nullable();
            $table->foreign('id_nguoithem')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('hoi_thao_khoa_hocs');
    }
};
