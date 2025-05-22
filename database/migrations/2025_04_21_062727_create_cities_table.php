<?php

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('city', function (Blueprint $table) {
            $table->integerIncrements('city_id');
            $table->string('city_name', 50);
            $table->string('city_code', 30);
            $table->string('city_image_name');
            $table->unsignedInteger('sms_available')->default(0);
            $table->unsignedInteger('city_saved_by')->default(0);
            $table->unsignedInteger('city_save_status')->default(0);
            $table->timestamp('city_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('city');
    }
};
