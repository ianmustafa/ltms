<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->belongsTo(Locale::class);
    }

    /**
     * Tags assigned to the translation.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'translation_tag', 'translation_id', 'tag_id');
    }
}
