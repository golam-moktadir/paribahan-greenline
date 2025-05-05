<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('work_group', function (Blueprint $table) {
            $table->mediumIncrements('work_group_id');
            $table->string('work_group_name', 100)->default('');
            $table->unsignedInteger('work_group_saved_by')->default(0);
            $table->unsignedMediumInteger('work_group_save_status')->default(0);
            $table->timestamp('work_group_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_group');
    }
};
