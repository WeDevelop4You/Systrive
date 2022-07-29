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
        Schema::create('git_account_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('git_account_id')->constrained()->cascadeOnDelete();
            $table->text('token');
            $table->text('refresh_token')->nullable();
            $table->bigInteger('expires_in')->nullable();
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
        Schema::dropIfExists('git_account_access_tokens');
    }
};
