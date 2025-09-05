<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Translatable\HasTranslations;

class Blog extends Model
{

    use HasTranslations;

    public $translatable = ['title', 'content'];

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'category_blog_id',
        'is_active',
        'is_featured',
        'author_id',
        'author_name',
        'views'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(CategoryBlog::class, 'category_blog_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function getExcerptAttribute()
    {
        $excerpt = strip_tags($this->content);
        return strlen($excerpt) > 200 ? substr($excerpt, 0, 200) . '...' : $excerpt;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getReadingTime()
    {
        $content = strip_tags($this->getTranslation('content', 'vi'));
        $wordCount = str_word_count($content);
        $readingTime = ceil($wordCount / 200); // 200 words per minute
        return max(1, $readingTime); // Minimum 1 minute
    }
}
