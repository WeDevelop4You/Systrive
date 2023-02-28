<?php

use Domain\Cms\Models\CmsTable;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    protected $connection = 'cms';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('cms_columns', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CmsTable::class, 'table_id')->constrained('cms_tables')->onDelete('cascade');
            $table->string('label');
            $table->string('key', 64);
            $table->integer('type');
            $table->integer('after');
            $table->boolean('hidden')->default(false);
            $table->boolean('editable')->default(true);
            $table->boolean('deletable')->default(true);
            $table->boolean('selectable')->default(false);
            $table->boolean('creatable')->default(false);
            $table->boolean('updatable')->default(false);
            $table->json('properties');
            $table->timestamps();

            $table->unique(['table_id', 'key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('cms_columns');
    }
};
