<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Convert existing single-string foto values to JSON arrays before changing column type
        DB::table('products')->whereNotNull('foto')->where('foto', '!=', '')->orderBy('id')->each(function ($product) {
            $decoded = json_decode($product->foto, true);
            if (!is_array($decoded)) {
                DB::table('products')->where('id', $product->id)
                    ->update(['foto' => json_encode([$product->foto])]);
            }
        });

        Schema::table('products', function (Blueprint $table) {
            $table->text('foto')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('foto')->nullable()->change();
        });
    }
};
