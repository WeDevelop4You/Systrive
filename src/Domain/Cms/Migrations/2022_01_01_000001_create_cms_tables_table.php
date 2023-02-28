<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    protected $connection = 'cms';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('cms_tables', function (Blueprint $table) {
            $table->id();
            $table->string('label')->unique();
            $table->string('name', 64)->unique();
            $table->string('query')->unique();
            $table->boolean('editable')->default(true);
            $table->boolean('queryable')->default(false);
            $table->boolean('mutable')->default(false);
            $table->boolean('deletable')->default(false);
            $table->boolean('is_table')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_tables');
    }
};
