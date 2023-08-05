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
        Schema::create('xep_hang_tap_chis', function (Blueprint $table) {
            $table->id();
            //Tạp chí nào
            $table->unsignedBigInteger('id_tapchi');
            $table->foreign('id_tapchi')->references('id')->on('tap_chis')->onDelete('cascade');
            //Có thuộc wos không? (nhận các giá trị: null; SCIE; SSCI; A&HCI; ESCI)
            $table->string('wos')->nullable();
            $table->string('if')->nullable();
            //Có thuộc scopus không? (nhận các giá trị q1->q4)
            $table->string('quartile')->nullable();
            //có thuộc ABS không? (nhận các giá trị null; 1->4)
            $table->string('abs')->nullable();
            //có thuộc ABCD không? (nhận các giá trị null; A*, A, B, C)
            $table->string('abcd')->nullable();

            $table->string('ghichu')->nullable();
            $table->unsignedBigInteger('id_user')->nullable();
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('xep_hang_tap_chis');
    }
};
