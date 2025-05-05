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
        Schema::create('transport', function (Blueprint $table) {
            $table->mediumIncrements('transport_id');
            $table->string('transport_name', 100)->default('');
            $table->string('transport_organization_name', 100)->default('');
            $table->string('transport_short_name', 50)->nullable();
            $table->string('transport_address');
            $table->unsignedMediumInteger('transport_total_station')->default(0);
            $table->unsignedMediumInteger('transport_total_bus')->default(0);
            $table->unsignedMediumInteger('transport_total_employee')->default(0);
            $table->unsignedMediumInteger('transport_total_route')->default(0);
            $table->unsignedMediumInteger('transport_city_id')->default(0);
            $table->unsignedMediumInteger('transport_postcode')->default(0);
            $table->date('transport_date_of_establishment')->default('1970-01-01');
            $table->string('transport_phone', 100)->default('');
            $table->string('transport_mobile', 100)->default('');
            $table->string('transport_fax', 100)->default('');
            $table->string('transport_email', 100)->default('');
            $table->string('transport_web')->default('');
            $table->string('transport_owner_name', 100)->default('');
            $table->string('transport_owner_phone', 100)->default('');
            $table->string('transport_owner_mobile', 100)->default('');
            $table->string('transport_owner_email')->default('');
            $table->string('transport_owner_fax', 100)->default('');
            $table->unsignedMediumInteger('transport_interest_1')->default(0);
            $table->unsignedMediumInteger('transport_interest_2')->default(0);
            $table->unsignedMediumInteger('transport_interest_3')->default(0);
            $table->unsignedMediumInteger('transport_interest_4')->default(0);
            $table->unsignedMediumInteger('transport_interest_5')->default(0);
            $table->unsignedMediumInteger('transport_interest_6')->default(0);
            $table->string('transport_comments')->default('');
            $table->string('transport_administrative_login', 30)->default('');
            $table->string('transport_administrative_password')->default('');
            $table->unsignedInteger('image_id')->default(0);
            $table->string('transport_homepage_text');
            $table->unsignedInteger('transport_saved_by')->default(0);
            $table->unsignedMediumInteger('transport_save_status')->default(0);
            $table->string('server_ip', 30);
            $table->unsignedInteger('transport_rank')->default(0);
            $table->timestamp('transport_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->string('server_lan_ip', 30)->default('0.0.0.0');
            $table->string('transport_code', 30)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transport');
    }
};
