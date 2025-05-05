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
        Schema::create('employee', function (Blueprint $table) {
            $table->unsignedInteger('employee_id')->primary()->default(0);
            $table->unsignedMediumInteger('transport_id')->default(0);
            $table->unsignedMediumInteger('department_id')->default(0);
            $table->unsignedMediumInteger('work_group_id')->default(0);
            $table->string('employee_name', 100)->default('');
            $table->string('employee_login', 50)->default('');
            $table->string('employee_password')->default('');
            $table->string('employee_new_password')->default('');
            $table->date('employee_birth_date')->default('1970-01-01');
            $table->date('employee_joining_date')->default('1970-01-01');
            $table->string('employee_permanent_address')->default('');
            $table->string('employee_present_address')->default('');
            $table->string('employee_phone', 100)->default('');
            $table->unsignedInteger('employee_pre_experience')->default(0);
            $table->string('employee_reference', 100)->default('');
            $table->unsignedInteger('employee_saved_by')->default(0);
            $table->unsignedMediumInteger('employee_save_status')->default(0);
            $table->timestamp('employee_timestamp')->useCurrent()->useCurrentOnUpdate();
            $table->string('employee_activation_id', 100)->default('');
            $table->string('employee_signature', 30)->nullable();
            $table->unsignedMediumInteger('can_cancel_sold')->default(0);
            $table->unsignedMediumInteger('can_book')->default(0);
            $table->unsignedMediumInteger('can_sell_complimentary')->default(0);
            $table->unsignedMediumInteger('can_gave_discount')->default(0);
            $table->unsignedInteger('max_discount')->default(0);
            $table->unsignedMediumInteger('can_cancel_web_ticket')->default(0)->comment('Can cancel online or web or G series ticket');
            $table->string('employee_identity', 20)->nullable();
            $table->string('nid_no', 30)->nullable();
            $table->string('birth_no', 30)->nullable();
            $table->string('avatar_url')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // $table->index(['transport_id', 'department_id', 'work_group_id', 'employee_login']);
            $table->index(
                ['transport_id', 'department_id', 'work_group_id', 'employee_login'],
                'transport_dept_group_login_idx'
            );

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee');
    }
};
