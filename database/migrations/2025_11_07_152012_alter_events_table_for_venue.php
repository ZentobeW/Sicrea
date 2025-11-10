<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Perintah untuk MENERAPKAN perubahan Anda.
     */
    public function up(): void
    {
        // Kita beritahu Laravel untuk mengubah tabel 'events'
        Schema::table('events', function (Blueprint $table) {
            
            // 1. Mengubah nama 'location' menjadi 'venue_address'
            $table->renameColumn('location', 'venue_address');

            // 2. Menambah kolom 'venue_name' dan 'tutor_name'
            //    Kita letakkan 'after' agar posisinya rapi di database
            $table->string('venue_name')->after('end_at');
            $table->string('tutor_name')->after('venue_address');

            // 3. Menghapus kolom 'slug'
            $table->dropColumn('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * Perintah untuk MEMBATALKAN perubahan (jika
     * Anda menjalankan 'migrate:rollback').
     */
    public function down(): void
    {
        // Ini adalah kebalikan dari perintah 'up', untuk jaga-jaga
        Schema::table('events', function (Blueprint $table) {
            
            // 1. Mengubah nama kembali
            $table->renameColumn('venue_address', 'location');

            // 2. Menghapus kolom baru
            $table->dropColumn('venue_name');
            $table->dropColumn('tutor_name');

            // 3. Mengembalikan kolom 'slug'
            $table->string('slug')->unique()->after('title')->nullable();
        });
    }
};