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
        Schema::create('offences', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('driver_id');
            $table->enum('offence_type', [
                'pending',
                'review',
                'action',
            ])->default('pending');
            $table->date('occurrence_date');
            $table->string('description');
            $table->string('complainant_name')->nullable();
            $table->string('complainant_phone', 20)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offences');
    }
};
