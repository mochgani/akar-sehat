<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add locale column
        Schema::table('settings', function (Blueprint $table) {
            $table->string('locale', 10)->default('id')->after('key');
        });

        // 2. Set all existing rows to locale = 'id'
        DB::table('settings')->update(['locale' => 'id']);

        // 3. Drop old unique on key, add composite unique on (key, locale)
        Schema::table('settings', function (Blueprint $table) {
            $table->dropUnique(['key']);
            $table->unique(['key', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropUnique(['key', 'locale']);
        });

        // Keep only 'id' locale rows, then drop column
        DB::table('settings')->where('locale', '!=', 'id')->delete();

        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn('locale');
        });

        Schema::table('settings', function (Blueprint $table) {
            $table->unique('key');
        });
    }
};
