<?php

namespace Database\Seeders;

use App\Models\Locale;
use App\Models\Tag;
use Carbon\Carbon;
use App\Models\Translation;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;

class TranslationSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $count = env('TRANSLATION_SEED_COUNT', 150000);
        $chunk = env('TRANSLATION_SEED_CHUNK', 5000);

        $locales = Locale::all()->pluck('code');
        $tags = Tag::all()->pluck('id');

        while ($count > 0) {
            $t = microtime(true);
            $translations = Translation::factory()
                ->count($chunk)
                ->create([
                    'locale' => $locales->random()
                ]);
            // Translation::insert($translations->toArray());
            $pivot = $translations->map(
                fn($item) => $tags->map(
                    fn($tag) => [
                        'translation_id' => $item->id,
                        'tag_id' => $tag,
                    ],
                ),
            )->flatten(1)->toArray();
            DB::table('translation_tag')->insert($pivot);
            dump($count, microtime(true) - $t);
            $count -= $chunk;
        }
        Translation::whereNull('created_at')->update([
            'created_at' => new Carbon()->toDateTimeString(),
            'updated_at' => new Carbon()->toDateTimeString(),
        ]);
    }
}
