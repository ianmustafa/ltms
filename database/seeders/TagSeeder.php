<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->insert([
            ['name' => 'Web', 'slug' => 'web'],
            ['name' => 'Mobile', 'slug' => 'mobile'],
            ['name' => 'Desktop', 'slug' => 'desktop'],
        ]);
    }
}
