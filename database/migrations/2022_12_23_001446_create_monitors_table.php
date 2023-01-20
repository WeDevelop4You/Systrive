<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up()
    {
        Schema::create('monitors', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('name');
            $table->smallInteger('status');
            $table->string('started')->nullable();
            $table->string('ended')->nullable();
            $table->timestamps(3);
        });
    }

    public function down()
    {
        Schema::dropIfExists('monitors');
    }
};
