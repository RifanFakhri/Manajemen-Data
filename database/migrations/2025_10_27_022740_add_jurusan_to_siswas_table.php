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
        // Kita gunakan Schema::table() karena tabel 'siswas' sudah ada
        Schema::table('siswas', function (Blueprint $table) {
            
            // Daftar pilihan jurusan
            $jurusanOptions = ['TKJ', 'RPL', 'MM', 'TJA'];

            // Tambahkan kolom 'jurusan' sebagai enum
            // Kita letakkan setelah 'email' dan membuatnya 'nullable'
            // (agar data lama tidak error)
            $table->enum('jurusan', $jurusanOptions)
                  ->after('email')
                  ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('siswas', function (Blueprint $table) {
            // Ini untuk membatalkan (rollback) migration
            $table->dropColumn('jurusan');
        });
    }
};
