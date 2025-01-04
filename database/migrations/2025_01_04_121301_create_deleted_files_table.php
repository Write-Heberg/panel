<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deleted_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('server_id');
            $table->string('directory');
            $table->string('file_name');
            $table->boolean('is_file');
            $table->integer('size');
            $table->timestamp('deleted_at');
            $table->timestamps();

            $table->foreign('server_id')->references('id')->on('servers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('deleted_files');
    }
};