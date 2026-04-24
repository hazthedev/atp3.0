<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_code')->nullable()->unique()->after('id');
            $table->string('defaults')->nullable()->after('name');
            $table->boolean('is_superuser')->default(false)->after('defaults');
            $table->boolean('is_mobile_user')->default(false)->after('is_superuser');
            $table->boolean('is_group')->default(false)->after('is_mobile_user');

            // General tab
            $table->string('ms_windows_account')->nullable()->after('is_group');
            $table->string('employee')->nullable()->after('ms_windows_account');
            $table->string('mobile_phone')->nullable()->after('employee');
            $table->string('mobile_device_id')->nullable()->after('mobile_phone');
            $table->string('fax')->nullable()->after('mobile_device_id');
            $table->string('branch')->default('Main')->after('fax');
            $table->string('department')->default('General')->after('branch');

            $table->boolean('password_never_expires')->default(false)->after('password');
            $table->boolean('change_password_next_logon')->default(true)->after('password_never_expires');
            $table->boolean('is_locked')->default(false)->after('change_password_next_logon');
            $table->boolean('enable_integration_packages')->default(false)->after('is_locked');

            // Services + Display stored as JSON blobs
            $table->json('services')->nullable()->after('enable_integration_packages');
            $table->json('display')->nullable()->after('services');

            $table->timestamp('last_login_at')->nullable()->after('display');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'user_code', 'defaults',
                'is_superuser', 'is_mobile_user', 'is_group',
                'ms_windows_account', 'employee', 'mobile_phone', 'mobile_device_id', 'fax',
                'branch', 'department',
                'password_never_expires', 'change_password_next_logon', 'is_locked', 'enable_integration_packages',
                'services', 'display', 'last_login_at',
            ]);
        });
    }
};
