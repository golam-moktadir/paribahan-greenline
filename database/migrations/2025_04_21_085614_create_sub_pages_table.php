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
        Schema::create('subpage', function (Blueprint $table) {
            $table->integerIncrements('subpage_id');
            $table->unsignedInteger('page_id')->nullable()->default(0);
            $table->string('subpage_name')->nullable();
            $table->string('subpage_title')->nullable();
            $table->unsignedInteger('subpage_saved_by')->nullable();
            $table->unsignedInteger('subpage_save_status')->nullable();
            $table->timestamp('subpage_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subpage');
    }
};
