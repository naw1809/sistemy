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
        Schema::create('minutas', function (Blueprint $table) {
            $table->id(); // ID_Minuta
            $table->foreignId('bast_id')->constrained('bast_minutas')->onDelete('cascade'); // Relasi "Mempunyai"
            $table->foreignId('user_id')->constrained('users'); // Relasi "Diproses"
            $table->string('no_minuta');
            $table->string('jenis_minuta');
            $table->string('pejabat_bank');
            $table->string('nama_debitur');
            $table->string('developer');
            $table->date('tgl_minuta');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minutas');
    }
};
