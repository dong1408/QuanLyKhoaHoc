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
            $table->text('name')->unique();
            $table->string('id_donvitochuc')->nullable();
            $table->foreign('id_donvitochuc')->references('id')->on('d_m_noi_cong_tacs')->onDelete('cascade');

            $table->string('diadiemtochuc')->nullable();
            $table->string('id_diadiemtochuc_city')->nullable();
            $table->foreign('id_diadiemtochuc_city')->references('id')->on('d_m_tinh_thanhs')->onDelete('cascade');

            $table->string('id_diadiemtochuc_country')->nullable();
            $table->foreign('id_diadiemtochuc_country')->references('id')->on('d_m_quoc_gias')->onDelete('cascade');
            $table->string('ngonngu')->nullable();
            $table->string('caphoithao')->nullable();

            $table->string('id_nhaxuatban')->nullable();
            $table->foreign('id_nhaxuatban')->references('id')->on('d_m_nha_xuat_bans')->onDelete('cascade');
            $table->string('website')->nullable();

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
