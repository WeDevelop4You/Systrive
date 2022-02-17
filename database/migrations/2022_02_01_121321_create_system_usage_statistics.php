<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemUsageStatistics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_usage_statistics', function (Blueprint $table) {
            $table->morphs('model');
            $table->string('type');
            $table->integer('total')->default(0);
            $table->date('date');
            $table->timestamps();
            $table->unique(['model_type', 'model_id', 'type', 'date'], 'usage_statistic_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_usage_statistics');
    }
}
