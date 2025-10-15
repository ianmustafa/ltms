<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Translation extends Model
{
    /** @use HasFactory<\Database\Factories\TranslationFactory> */
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'locale_id',
        'key',
        'value',
    ];

    /**
     * Get the locale for the translation.
     */
    public function locale()
    {
        return $this->belongsTo(Locale::class, 'locale', 'code');
    }

    /**
     * Tags assigned to the translation.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'translation_tag', 'translation_id', 'tag_id');
    }

    /**
     * Scope to filter by tags.
     */
    #[Scope]
    public function withTags(Builder $query, array $tagSlugs = [])
    {
        if (!empty($tagSlugs)) {
            return $query->whereHas('tags', function ($q) use ($tagSlugs) {
                $q->whereIn('slug', $tagSlugs);
            });
        }
        return $query;
    }

    /**
     * Scope to search by key or value.
     */
    #[Scope]
    public function scopeSearch(Builder $query, $searchTerm = null)
    {
        if ($searchTerm) {
            return $query->where(function ($q) use ($searchTerm) {
                $q->whereLike('key', 'like', "%{$searchTerm}%")
                  ->orWhereLike('value', 'like', "%{$searchTerm}%");
            });
        }
        return $query;
    }
}
