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
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('company')->nullable()->after('last_name'); // نام شرکت
            $table->string('job_title')->nullable()->after('company'); // سمت شغلی
            $table->string('city')->nullable()->after('address');      // شهر
            $table->string('province')->nullable()->after('city');    // استان
            $table->string('website')->nullable()->after('email');     // وب‌سایت
            $table->string('type')->default('lead')->after('notes');   // نوع مشتری: سرنخ، مشتری فعلی، وفادار
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            //
        });
    }
};
