<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_templates', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->string('name')->nullable();
            $table->string('type');
            $table->boolean('is_public')->default(0);
            $table->timestamps();
            $table->unique(['value', 'type'], 'template_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_security');
    }
};
