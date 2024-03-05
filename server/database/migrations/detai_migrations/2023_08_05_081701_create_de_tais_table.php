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
        Schema::create('de_tais', function (Blueprint $table) {
            $table->id();
            //Đề tài nào
            $table->unsignedBigInteger('id_sanpham');
            $table->foreign('id_sanpham')->references('id')->on('san_phams')->onDelete('cascade');
            //Thông tin chi tiết đề tài
            $table->string('maso')->unique();
            $table->string('ngaydangky')->nullable();
            //Đề tài ngoài trường đúng không
            $table->boolean('ngoaitruong')->nullable();
            //Đề tài ngoài trường do Trường chủ trì đúng không?
            $table->boolean('truongchutri')->nullable();
            //Tổ chức chủ quản là tổ chức nào
            $table->unsignedBigInteger('id_tochucchuquan')->nullable();
            $table->foreign('id_tochucchuquan')->references('id')->on('d_m_to_chucs')->onDelete('cascade');
            //Trường hợp đề tài trong trường thì thuộc loại nào?
            $table->unsignedBigInteger('id_loaidetai')->nullable();
            $table->foreign('id_loaidetai')->references('id')->on('phan_loai_de_tais')->onDelete('cascade');
            //Đề tài hợp tác đúng không
            $table->boolean('detaihoptac')->nullable();
            $table->unsignedBigInteger('id_tochuchoptac')->nullable();
            $table->foreign('id_tochuchoptac')->references('id')->on('d_m_to_chucs')->onDelete('cascade');
            $table->string('tylekinhphidonvihoptac')->nullable();
            //Cấp đề tài: Khoa, Cơ sở, Tỉnh, Bộ, Ngành, Nhà nước, Nước ngoài
            $table->string('capdetai')->nullable();

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
        Schema::dropIfExists('de_tais');
    }
};
