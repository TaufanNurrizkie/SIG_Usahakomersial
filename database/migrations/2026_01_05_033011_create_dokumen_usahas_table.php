<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_usahas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usaha_id')->constrained('usahas')->onDelete('cascade');
            $table->enum('jenis_dokumen', ['KTP', 'foto_lokasi', 'lainnya']);
            $table->string('file_path');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_usahas');
    }
};
