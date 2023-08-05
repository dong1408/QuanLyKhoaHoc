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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('email2')->nullable();
            $table->string('password');
            $table->text('ngaysinh')->nullable();
            $table->string('dienthoai')->nullable();

            $table->string('mavienchuc')->unique()->nullable(); //mã viên chức
            $table->unsignedBigInteger('id_noicongtac')->nullable();
            $table->foreign('id_noicongtac')->references('id')->on('d_m_to_chucs')->onDelete('cascade');
            $table->unsignedBigInteger('id_donvi')->nullable();
            $table->foreign('id_donvi')->references('id')->on('d_m_don_vis')->onDelete('cascade');
            $table->unsignedBigInteger('id_quoctich')->nullable();
            $table->foreign('id_quoctich')->references('id')->on('d_m_quoc_gias')->onDelete('cascade');
            $table->unsignedBigInteger('id_hochamhocvi')->nullable();
            $table->foreign('id_hochamhocvi')->references('id')->on('d_m_hoc_ham_hoc_vis')->onDelete('cascade');
            $table->unsignedBigInteger('id_ngachvienchuc')->nullable();
            $table->foreign('id_ngachvienchuc')->references('id')->on('d_m_ngach_vien_chucs')->onDelete('cascade');
            $table->unsignedBigInteger('id_chuyenmon')->nullable();
            $table->foreign('id_chuyenmon')->references('id')->on('d_m_chuyen_mons')->onDelete('cascade');

            $table->string('orchid')->nullable();
            $table->integer('role')->default(0);
            $table->boolean('changed')->default(0); //check xem đã đổi mật khẩu chưa?
            $table->rememberToken();
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
