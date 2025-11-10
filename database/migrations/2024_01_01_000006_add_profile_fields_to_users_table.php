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
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('email');
            $table->date('birth_date')->nullable()->after('phone');
            $table->string('province')->nullable()->after('birth_date');
            $table->string('city')->nullable()->after('province');
            $table->string('address')->nullable()->after('city');
            $table->string('avatar_path')->nullable()->after('address');

            $table->index(['phone']);
            $table->index(['province']);
            $table->index(['city']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'birth_date',
                'province',
                'city',
                'address',
                'avatar_path',
            ]);
        });
    }
};
