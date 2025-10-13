<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'test-user',
            'email' => 'test@example.com',
        ]);

        // Create a personal access token for convenience (stored locally in storage/app/private/test_token.txt)
        // This helps quickly test authenticated endpoints without manual login.
        $token = $user->createToken('seed-token')->plainTextToken;

        Storage::disk('local')->put('test-user-seed-token.txt', $token);
    }
}
