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
        Schema::create('page_catagory', function (Blueprint $table) {
            $table->integerIncrements('page_catagory_id');
            $table->string('page_catagory_type', 100);
            $table->unsignedInteger('page_catagory_saved_by')->default(0);
            $table->unsignedInteger('page_catagory_save_status')->default(0);
            $table->timestamp('page_catagory_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_catagory');
    }
};
