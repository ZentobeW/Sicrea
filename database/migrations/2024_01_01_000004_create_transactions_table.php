<?php

use App\Enums\PaymentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registration_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('amount');
            $table->string('status')->default(PaymentStatus::Pending->value)->index();
            $table->string('payment_method')->nullable();
            $table->string('payment_proof_path')->nullable();
            $table->dateTime('paid_at')->nullable()->index();
            $table->dateTime('verified_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
