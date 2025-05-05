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
        Schema::create('member_type', function (Blueprint $table) {
            $table->mediumIncrements('member_type_id');
            $table->string('member_type_name', 100)->default('');
            $table->string('member_type_url', 100)->default('');
            $table->unsignedInteger('member_type_saved_by')->default(0);
            $table->unsignedMediumInteger('member_type_save_status')->default(0);
            $table->timestamp('member_type_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member_type');
    }
};
