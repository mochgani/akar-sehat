<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('sku')->unique();
            $table->string('kategori');
            $table->unsignedBigInteger('harga');
            $table->integer('stok')->default(0);
            $table->enum('status', ['tersedia', 'hampir-habis', 'habis'])->default('tersedia');
            $table->longText('kandungan')->nullable(); // HTML (WYSIWYG)
            $table->text('deskripsi')->nullable();
            $table->text('cara_pakai')->nullable();
            $table->string('foto')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
