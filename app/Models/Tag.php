<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Get translations for the tag.
     */
    public function translations()
    {
        return $this->belongsToMany(Translation::class, 'translation_tag', 'tag_id', 'translation_id');
    }
}
