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
        Schema::create('bast_minutas', function (Blueprint $table) {
            $table->id(); // Ini adalah ID_BAST
            $table->foreignId('user_id')->constrained('users'); // Relasi "Membuat" dari Users
            $table->date('tgl_diserahkan');
            $table->date('tgl_diterima')->nullable();
            $table->string('status');
            $table->string('kc_btn');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bast_minutas');
    }
};
