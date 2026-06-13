<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('related_ids')->nullable()->after('is_featured'); // produk terkait manual
            $table->decimal('harga_usd', 12, 2)->nullable()->after('harga'); // harga dalam USD
            $table->decimal('harga_sar', 12, 2)->nullable()->after('harga_usd'); // harga dalam SAR
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['related_ids', 'harga_usd', 'harga_sar']);
        });
    }
};
