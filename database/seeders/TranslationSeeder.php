<?php

namespace Database\Seeders;

use App\Models\Translation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TranslationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = env('TRANSLATION_SEED_COUNT', 100000);
        $chunk = env('TRANSLATION_SEED_COUNT', 1000);
        while ($count > 0) {
            $translations = Translation::factory()->count($chunk)->make()->toArray();
            Translation::insert($translations);
            $count -= $chunk;
        }
    }
}
