<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Enums\RefundStatus;
use App\Enums\RegistrationStatus;
use App\Models\Event;
use App\Models\Portfolio;
use App\Models\RefundRequest;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory()->create([
            'name' => 'Test',
            'email' => 'test@test.com',
            'phone' => '1234567890',
            'birth_date' => '2000-01-01',
            'province' => 'East Java',
            'city' => 'Surabaya',
            'address' => 'Jl. Test No. 1',
            'is_admin' => false,
            'password' => Hash::make('password'),
        ]);
    }
}
