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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->unsignedMediumInteger('transport_id')->default(0);
            $table->unsignedMediumInteger('department_id')->default(0);
            $table->string('full_name');
            $table->string('father_name');
            $table->date('birth_date')->default('1970-01-01');
            $table->string('phone', 20)->unique();
            $table->string('id_no', 20)->unique()->nullable();
            $table->string('nid_no', 20)->unique();
            $table->string('driving_license_no', 20)->unique();
            $table->string('insurance_no', 40)->unique()->nullable();
            $table->string('present_address');
            $table->string('permanent_address');
            $table->unsignedMediumInteger('pre_experience')->default(0);
            $table->date('joining_date')->default('1970-01-01');
            $table->string('status', 5)->comment('0=> inactive, 1=> active, 2=> on-leave, 
            3=> on-review, 4=> on-hold, 5=> terminated, 6=> accident, 7=> retired, 8=> death');
            $table->string('reference', 100);
            $table->string('avatar_url')->nullable();
            $table->string('nid_front_attachment')->default('assets/images/default/nid_front_.png');
            $table->string('nid_back_attachment')->default('assets/images/default/nid_back.jpg');
            $table->string('driving_license_front_attachment')->default('assets/images/default/driving_license_front.png');
            $table->string('driving_license_back_attachment')->default('assets/images/default/driving_license_back.jpg');
            $table->string('insurance_attachment')->nullable();
            $table->unsignedInteger('created_by')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
