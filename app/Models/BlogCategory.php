<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;
    use HasFactory;

    const ROOT = 1;

    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'description',
    ];

    protected $appends = [
        'parent_title',
    ];

    /**
     * Батьківська категорія
     */
    public function parentCategory()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id', 'id');
    }

    /**
     * Accessor для назви батьківської категорії.
     */
    public function getParentTitleAttribute()
    {
        $title = $this->parentCategory?->title
            ?? ($this->isRoot()
                ? 'Корінь'
                : '???');

        return $title;
    }

    /**
     * Перевірка чи об'єкт є кореневим.
     */
    public function isRoot()
    {
        return $this->id === BlogCategory::ROOT;
    }
}
