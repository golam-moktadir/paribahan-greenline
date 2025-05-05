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
        Schema::create('page_access_type', function (Blueprint $table) {
            $table->integerIncrements('page_access_type_id');
            $table->string('page_access_type_name', 100);
            $table->unsignedInteger('page_catagory_id')->default(0);
            $table->string('page_access_type_url', 100);
            $table->unsignedInteger('page_access_type_saved_by')->default(0);
            $table->unsignedInteger('page_access_type_save_status')->default(0);
            $table->timestamp('page_access_type_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('page_access_type');
    }
};
