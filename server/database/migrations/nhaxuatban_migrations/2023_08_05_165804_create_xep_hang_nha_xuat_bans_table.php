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
        Schema::create('xep_hang_nha_xuat_bans', function (Blueprint $table) {
            $table->id();
            //Nhà xuất bản nào
            $table->unsignedBigInteger('id_nxb');
            $table->foreign('id_nxb')->references('id')->on('nha_xuat_bans')->onDelete('cascade');
            //Có thuộc wos không? (nhận các giá trị: null; SCIE; SSCI; A&HCI; ESCI)
            $table->string('wos')->nullable();
            $table->string('if')->nullable();
            //Có thuộc scopus không? (nhận các giá trị q1->q4)
            $table->string('quartile')->nullable();
            //có thuộc ABS không? (nhận các giá trị null; 1->4)
            $table->string('abs')->nullable();
            //có thuộc ABCD không? (nhận các giá trị null; A*, A, B, C)
            $table->string('abcd')->nullable();
            //có điểm uy tín không (0 - 100)
            $table->string('diemuytin')->nullable();

            $table->string('ghichu')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('xep_hang_nha_xuat_bans');
    }
};
