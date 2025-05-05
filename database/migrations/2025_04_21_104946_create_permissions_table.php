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
        Schema::create('permission', function (Blueprint $table) {
            $table->integerIncrements('permission_id');
            $table->unsignedInteger('employee_id')->default(0);
            $table->unsignedInteger('page_id')->default(0);
            $table->unsignedInteger('permission_view')->default(0);
            $table->unsignedInteger('permission_insert')->default(0);
            $table->unsignedInteger('permission_update')->default(0);
            $table->unsignedInteger('permission_delete')->default(0);
            $table->unsignedInteger('permission_saved_by')->default(0);
            $table->unsignedInteger('permission_save_status')->default(0);
            $table->timestamp('permission_time_stamp')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permission');
    }
};
