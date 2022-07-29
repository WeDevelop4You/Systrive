<?php

use Domain\Job\Models\JobOperation;
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
        Schema::create('job_operations', function (Blueprint $table) {
            $table->id();
            $table->string('schedule_type')->nullable();
            $table->foreignIdFor(JobOperation::class, 'parent_id')->nullable()->constrained('job_operations')->cascadeOnDelete();
            $table->uuid()->nullable();
            $table->string('name')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('status')->default(0);
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
        Schema::dropIfExists('job_operations');
    }
};
