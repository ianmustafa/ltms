<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Locale;
use App\Models\Translation;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TranslationRepository
{
    /**
     * Get paginated translations with search and tag filtering.
     */
    public function getTranslations(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        /** @var \Illuminate\Database\Eloquent\Builder */
        $query = Translation::with(['tags:slug'])
            ->select('id', 'key', 'value', 'locale', 'created_at', 'updated_at')
            ->search($filters['search'] ?? null)
            ->withTags($filters['tags'] ?? []);

        return $query->paginate($perPage, [
            'key',
            'value',
            'locale',
            'created_at',
            'updated_at',
        ]);
    }

    /**
     * Find a translation by ID with relationships.
     */
    public function findTranslation(int $id): ?Translation
    {
        return Translation::with(['locale:id,code,name', 'tags:id,slug,name'])->find($id)->setHidden(['deleted_at']);
    }

    /**
     * Create a new translation with tags.
     */
    public function createTranslation(array $data): Translation
    {
        $locale = Locale::where('code', $data['locale'])->firstOrFail();

        $translation = Translation::create([
            'locale_id' => $locale->id,
            'key' => $data['key'],
            'value' => $data['value'],
        ]);

        if (isset($data['tags']) && is_array($data['tags'])) {
            $tagIds = Tag::whereIn('slug', $data['tags'])->pluck('id');
            $translation->tags()->sync($tagIds);
        }

        return $translation->load(['locale:id,code,name', 'tags:id,slug,name']);
    }

    /**
     * Update a translation with tags.
     */
    public function updateTranslation(Translation $translation, array $data): Translation
    {
        $translation->update($data);

        if (isset($data['tags']) && is_array($data['tags'])) {
            $tagIds = Tag::whereIn('slug', $data['tags'])->pluck('id');
            $translation->tags()->sync($tagIds);
        }

        return $translation->load(['locale:id,code,name', 'tags:id,slug,name']);
    }

    /**
     * Delete a translation.
     */
    public function deleteTranslation(Translation $translation): bool
    {
        return $translation->delete();
    }

    /**
     * Export translations for a specific locale.
     */
    public function exportTranslations(string $localeCode): Collection
    {
        $locale = Locale::where('code', $localeCode)->firstOrFail();

        return Translation::where('locale_id', $locale->id)
            ->select('key', 'value')
            ->get()
            ->pluck('value', 'key');
    }
}
