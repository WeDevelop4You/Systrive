<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('cms_files', function (Blueprint $table) {
            $table->id();
            $table->string('table_type');
            $table->unsignedBigInteger('table_id');
            $table->string('table_key');
            $table->string('path');
            $table->string('name');
            $table->string('type');
            $table->unsignedBigInteger('size');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['table_type', 'table_id', 'table_key']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('cms_files');
    }
};
