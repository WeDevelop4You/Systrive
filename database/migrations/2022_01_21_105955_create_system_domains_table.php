<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemDomainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_domains', function (Blueprint $table) {
            $table->id();
            $table->foreignId('system_id')->constrained('system')->cascadeOnDelete();
            $table->string('name')->unique();
            $table->timestamps();
            $table->unique(['system_id', 'name'], 'system_user_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_domains');
    }
}
