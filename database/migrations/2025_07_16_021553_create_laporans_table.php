<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('laporans', function (Blueprint $table) {
            $table->id();

            // Foreign key ke user
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id_user')->on('user')->onDelete('cascade');


            // ID Tiket unik
            $table->string('ticket_id')->unique();

            // Foreign key ke kategoris
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');

            // Data laporan
            $table->string('url_situs')->nullable();
            $table->text('kendala');
            $table->string('lampiran')->nullable();
            $table->enum('status', ['Di Cek','Diproses', 'Selesai', 'Ditolak'])->default('Di Cek');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporans');
    }
};
