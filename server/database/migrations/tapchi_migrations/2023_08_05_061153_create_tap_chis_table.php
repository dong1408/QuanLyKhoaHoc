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
        Schema::create('tap_chis', function (Blueprint $table) {
            $table->id();
            $table->string('name',255)->unique();
            $table->string('issn')->nullable();
            $table->string('eissn')->nullable();
            $table->string('pissn')->nullable();
            $table->string('website')->nullable();
            $table->boolean('quocte')->nullable(); //phải quốc tế hay không
            //Thuộc nhà xuất bản nào không?
            $table->unsignedBigInteger('id_nhaxuatban')->nullable();
            $table->foreign('id_nhaxuatban')->references('id')->on('nha_xuat_bans')->onDelete('cascade');
            //Thuộc tổ chức nào không?
            $table->unsignedBigInteger('id_donvichuquan')->nullable();
            $table->foreign('id_donvichuquan')->references('id')->on('d_m_to_chucs')->onDelete('cascade');
            //Địa chỉ tạp chí
            $table->string('address')->nullable();
            $table->unsignedBigInteger('id_address_city')->nullable();
            $table->foreign('id_address_city')->references('id')->on('d_m_tinh_thanhs')->onDelete('cascade');
            $table->unsignedBigInteger('id_address_country')->nullable();
            $table->foreign('id_address_country')->references('id')->on('d_m_quoc_gias')->onDelete('cascade');
            //Status, mô tả trạng thái tạp chí đã được phê duyệt
            //Đề phòng tạp chí do Viên chức thêm vào
            $table->boolean('trangthai')->nullable(); //Đang xem xét; Được chấp thuận
            $table->unsignedBigInteger('id_nguoithem')->nullable();
            $table->foreign('id_nguoithem')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('d_m_tap_chis');
    }
};
