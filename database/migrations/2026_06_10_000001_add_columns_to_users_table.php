<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->string('wa')->nullable()->after('email');
            $table->text('bio')->nullable()->after('wa');
            $table->enum('role', ['administrator', 'editor', 'penulis', 'viewer'])->default('viewer')->after('bio');
            $table->enum('status', ['aktif', 'non-aktif', 'suspended'])->default('aktif')->after('role');
            $table->string('avatar_color', 7)->default('#C86A44')->after('status');
            $table->integer('login_count')->default(0)->after('avatar_color');
            $table->timestamp('last_login_at')->nullable()->after('login_count');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'wa', 'bio', 'role', 'status', 'avatar_color', 'login_count', 'last_login_at']);
        });
    }
};
