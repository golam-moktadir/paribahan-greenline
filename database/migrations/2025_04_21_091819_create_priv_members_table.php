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
        Schema::create('priv_member', function (Blueprint $table) {
            $table->integerIncrements('priv_member_id');
            $table->string('priv_member_name', 50);
            $table->string('priv_member_sl_no', 30);
            $table->string('priv_member_father', 50)->nullable();
            $table->string('priv_member_spouse', 50)->nullable();
            $table->unsignedInteger('priv_member_occupation_id')->default(0);
            $table->unsignedInteger('priv_member_designation_id')->default(0);
            $table->string('priv_member_office_institute');
            $table->text('priv_member_address');
            $table->string('priv_member_phone_office', 50);
            $table->string('priv_member_phone_mobile', 50);
            $table->string('priv_member_phone_residence', 50);
            $table->string('priv_member_blood', 30);
            $table->date('priv_member_date');
            $table->unsignedInteger('priv_member_saved_by')->default(0);
            $table->unsignedInteger('priv_member_save_status')->default(0);
            $table->timestamp('priv_member_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->unsignedInteger('priv_member_transport_id')->default(0);
            $table->unsignedInteger('general_member_id')->default(0);
            $table->string('pic_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('priv_member');
    }
};
