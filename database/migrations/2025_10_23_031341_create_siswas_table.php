<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_siswas_table.php
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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->string('nisn', 10)->unique(); // NISN 10 digit dan unik
            $table->date('tanggal_lahir');
            $table->string('nomor_kontak', 15); // Ganti dari 'kontak_broj'
            $table->string('email')->nullable(); // Email bisa jadi opsional
            $table->text('alamat')->nullable();
            $table->string('kota')->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->string('negara')->default('Indonesia');
            $table->string('dokumen_path')->nullable(); // Path untuk file Akta/KK
            $table->string('foto_profil_path')->nullable(); // Path untuk foto profil
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};