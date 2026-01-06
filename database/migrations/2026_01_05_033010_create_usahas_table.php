<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usahas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained('kategori_usahas')->onDelete('cascade');
            $table->foreignId('kelurahan_id')->constrained('kelurahans')->onDelete('cascade');
            $table->string('nama_usaha');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->string('foto_usaha')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('alamat');
            $table->enum('status', [
                'menunggu_admin',
                'ditolak_admin',
                'menunggu_camat',
                'ditolak_camat',
                'disetujui_camat'
            ])->default('menunggu_admin');
            $table->string('surat_izin')->nullable();
            $table->text('catatan_penolakan')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usahas');
    }
};
