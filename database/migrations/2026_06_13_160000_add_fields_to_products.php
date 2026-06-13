<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->longText('deskripsi_singkat')->nullable()->after('deskripsi'); // HTML (WYSIWYG)
            $table->longText('manfaat')->nullable()->after('deskripsi_singkat');     // HTML (WYSIWYG)
            $table->string('satuan')->nullable()->after('manfaat');                  // mis. "botol"
            $table->string('isi_kemasan')->nullable()->after('satuan');              // mis. "60 kapsul / botol"
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['deskripsi_singkat', 'manfaat', 'satuan', 'isi_kemasan']);
        });
    }
};
