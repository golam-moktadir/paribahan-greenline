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
        Schema::create('page', function (Blueprint $table) {
            $table->integerIncrements('page_id');
            $table->string('page_name', 100);
            $table->string('page_title', 100);
            $table->unsignedInteger('page_is_admin')->default(0);
            $table->string('page_desc')->nullable();
            $table->unsignedInteger('page_view_level')->default(0);
            $table->unsignedInteger('page_saved_by')->default(0);
            $table->unsignedInteger('page_save_status')->default(0);
            $table->timestamp('page_time_stamp')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedInteger('page_type_id')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page');
    }
};
