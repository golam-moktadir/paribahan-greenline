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
        Schema::create('member', function (Blueprint $table) {
            $table->integerIncrements('member_id');
            $table->unsignedMediumInteger('member_type_id')->default(0);
            $table->string('member_login', 30)->default('');
            $table->string('member_password', 255)->default('');
            $table->string('member_new_password', 255)->default('');
            $table->string('member_email', 255)->default('');
            $table->string('member_activation_id', 50)->default('');
            $table->timestamp('member_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedMediumInteger('member_save_status')->default(0);
            $table->unsignedMediumInteger('pass_changed')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('member');
    }
};
