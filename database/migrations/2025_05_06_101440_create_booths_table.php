<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('booth', function (Blueprint $table) {
            $table->id('booth_id');
            $table->string('booth_name');
            $table->unsignedInteger('booth_code')->nullable();
            $table->unsignedInteger('transport_id')->comment('Foreign Key - transport_id : transport');
            $table->unsignedInteger('station_id')->comment('Foreign Key - station_id : station');
            $table->unsignedInteger('booth_man_in_charge_employee_id')->comment('Foreign Key - employee_id : employee');
            $table->string('booth_address')->nullable();
            $table->string('booth_phone')->nullable();
            $table->unsignedInteger('booth_online_booking')->default(0);
            $table->unsignedInteger('booth_pocket_counter')->default(0);
            $table->unsignedInteger('booth_block')->default(0);
            $table->unsignedInteger('booth_saved_by');
            $table->unsignedInteger('booth_save_status')->default(0);
            $table->timestamp('employee_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->string('upload_time')->nullable();
            $table->string('download_time')->nullable();
            $table->string('booth_ip')->default('0.0.0.0');
            $table->enum('master_booth', ['0', '1', '2', '3'])->default(0);
            $table->unsignedInteger('parent_booth')->default(0);
            $table->string('account_upload_time')->nullable();
            $table->unsignedInteger('server_connection_status')->default(0);
            $table->string('booth_lan_ip')->default('0.0.0.0');
            $table->string('vat_no')->nullable();
            $table->string('currency')->default('TK');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('booth');
    }
};
