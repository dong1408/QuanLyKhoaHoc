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
        Schema::create('taggables', function (Blueprint $table) {
            //Sử dụng "many to many polymorphic relations laravel"
            $table->id();
            //Tag nào
            $table->unsignedBigInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            //Model nào, id nào
            $table->string('taggable_type');
            $table->integer('taggable_id');
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
        Schema::dropIfExists('taggables');
    }
};
