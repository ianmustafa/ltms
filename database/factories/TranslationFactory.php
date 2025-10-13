<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Locale;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Translation>
 */
class TranslationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Translation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $key = str_replace(' ', '.', $this->faker->unique()->words(3, true));

        return [
            'key' => substr($key, 0, 191),
            'locale_id' => Locale::inRandomOrder()->value('id') ?? 1,
            'value' => $this->faker->sentence(12),
            'created_at' => new Carbon(),
            'updated_at' => new Carbon(),
        ];
    }
}
