<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemUserDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_user_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('system_user_id')->constrained()->cascadeOnDelete();
            $table->string('name')->unique();
            $table->timestamps();
            $table->unique(['system_user_id', 'name'], 'system_user_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_user_domains');
    }
}
