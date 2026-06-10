<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('code', 10)->unique();       // id, en, ar
            $table->string('name');                      // Indonesia, English
            $table->string('native_name');               // Indonesia, English, العربية
            $table->string('dir', 3)->default('ltr');   // ltr | rtl
            $table->string('flag', 10)->nullable();      // 🇮🇩
            $table->boolean('aktif')->default(true);
            $table->boolean('is_default')->default(false);
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('languages');
    }
};
