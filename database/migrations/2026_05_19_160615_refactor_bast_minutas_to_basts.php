<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop foreign key in minutas first
        Schema::table('minutas', function (Blueprint $table) {
            $table->dropForeign(['bast_id']);
        });

        // Rename table
        Schema::rename('bast_minutas', 'basts');

        // Add tipe_bast to basts
        Schema::table('basts', function (Blueprint $table) {
            $table->string('tipe_bast')->after('user_id')->nullable();
        });

        // Update tipe_bast for old records
        DB::table('basts')->update(['tipe_bast' => 'BAST Salinan']);

        // Set tipe_bast to not nullable
        Schema::table('basts', function (Blueprint $table) {
            $table->string('tipe_bast')->nullable(false)->change();
        });

        // Modify bast_id in minutas to be nullable and reference basts instead
        Schema::table('minutas', function (Blueprint $table) {
            $table->unsignedBigInteger('bast_id')->nullable()->change();
            $table->foreign('bast_id')->references('id')->on('basts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('minutas', function (Blueprint $table) {
            $table->dropForeign(['bast_id']);
        });

        Schema::table('basts', function (Blueprint $table) {
            $table->dropColumn('tipe_bast');
        });

        Schema::rename('basts', 'bast_minutas');

        Schema::table('minutas', function (Blueprint $table) {
            $table->unsignedBigInteger('bast_id')->nullable(false)->change();
            $table->foreign('bast_id')->references('id')->on('bast_minutas')->onDelete('cascade');
        });
    }
};
