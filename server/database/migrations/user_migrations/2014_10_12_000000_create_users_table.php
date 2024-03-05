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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            //Thông tin đăng nhập
            $table->string('name');
            $table->string('username')->unique(); //Mã viên chức
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('role')->default(0);
            $table->boolean('changed')->default(0); //check xem đã đổi mật khẩu chưa?
            $table->rememberToken();
            //Thông tin cá nhân
            $table->text('ngaysinh')->nullable();
            $table->string('dienthoai')->nullable();
            $table->string('email2')->nullable();
            $table->string('orchid')->nullable();
            //Thuộc tổ chức, đơn vị nào
            $table->unsignedBigInteger('id_tochuc')->nullable();
            $table->foreign('id_tochuc')->references('id')->on('d_m_to_chucs')->onDelete('cascade');
            $table->unsignedBigInteger('id_donvi')->nullable();
            $table->foreign('id_donvi')->references('id')->on('d_m_don_vis')->onDelete('cascade');
            //Có phải cơ hữu không viên chức
            $table->boolean('cohuu')->nullable();
            //Có phải kéo dài không
            $table->boolean('keodai')->nullable();
            //Định mức NCKH bao nhiêu giờ
            $table->string('dinhmucnghiavunckh')->nullable();
            //Có phải đang đi học nghiên cứu sinh không (null; caohoc; ncs)
            $table->string('dangdihoc')->nullable();
            $table->unsignedBigInteger('id_noihoc')->nullable();
            $table->foreign('id_noihoc')->references('id')->on('d_m_to_chucs')->onDelete('cascade');

            //Ngạch viên chức (chỉ dùng cho Trường ĐHSG, để quản lý nội bộ)
            $table->unsignedBigInteger('id_ngachvienchuc')->nullable();
            $table->foreign('id_ngachvienchuc')->references('id')->on('d_m_ngach_vien_chucs')->onDelete('cascade');
            //Quốc tịch gì
            $table->unsignedBigInteger('id_quoctich')->nullable();
            $table->foreign('id_quoctich')->references('id')->on('d_m_quoc_gias')->onDelete('cascade');
            //Học hàm học vị ra sao
            $table->unsignedBigInteger('id_hochamhocvi')->nullable();
            $table->foreign('id_hochamhocvi')->references('id')->on('d_m_hoc_ham_hoc_vis')->onDelete('cascade');
            //Chuyên môn được đào tạo
            $table->unsignedBigInteger('id_chuyenmon')->nullable();
            $table->foreign('id_chuyenmon')->references('id')->on('d_m_chuyen_mons')->onDelete('cascade');
            //Chọn mình thuộc Hội đồng GSNN ngành nào
            $table->unsignedBigInteger('id_nganhtinhdiem')->nullable();
            $table->foreign('id_nganhtinhdiem')->references('id')->on('d_m_nganh_tinh_diems')->onDelete('cascade');
            //Chọn mình thuộc chuyên ngành nào của Hội đồng GSNN
            $table->unsignedBigInteger('id_chuyennganhtinhdiem')->nullable();
            $table->foreign('id_chuyennganhtinhdiem')->references('id')->on('d_m_chuyen_nganh_tinh_diems')->onDelete('cascade');

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
        Schema::dropIfExists('users');
    }
};
