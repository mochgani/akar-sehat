<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('translations')->nullable()->after('cara_pakai');
        });
        Schema::table('articles', function (Blueprint $table) {
            $table->json('translations')->nullable()->after('meta_desc');
        });
        Schema::table('testimonials', function (Blueprint $table) {
            $table->json('translations')->nullable()->after('isi');
        });
    }

    public function down(): void
    {
        Schema::table('products',     fn (Blueprint $t) => $t->dropColumn('translations'));
        Schema::table('articles',     fn (Blueprint $t) => $t->dropColumn('translations'));
        Schema::table('testimonials', fn (Blueprint $t) => $t->dropColumn('translations'));
    }
};
