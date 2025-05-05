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
        Schema::create('department', function (Blueprint $table) {
            $table->mediumIncrements('department_id');
            $table->string('department_name', 100)->default('');
            $table->unsignedInteger('department_saved_by')->default(0);
            $table->unsignedMediumInteger('department_save_status')->default(0);
            $table->timestamp('department_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department');
    }
};
