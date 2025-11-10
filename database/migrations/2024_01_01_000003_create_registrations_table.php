<?php

use App\Enums\PaymentStatus;
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
            $table->string('payment_status')->default(PaymentStatus::Pending->value)->index();
            $table->unsignedInteger('amount');
            $table->string('payment_proof_path')->nullable();
            $table->json('form_data');
            $table->dateTime('registered_at')->index();
            $table->dateTime('paid_at')->nullable()->index();
            $table->dateTime('verified_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
