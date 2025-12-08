<?php

use App\Enums\RegistrationStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('status')->default(RegistrationStatus::Pending->value)->index();
            $table->json('form_data');
            $table->dateTime('registered_at')->index();
            $table->text('notes')->nullable();
            $table->string('registered_name')->nullable();
            $table->string('registered_email')->nullable();
            $table->string('registered_phone')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
