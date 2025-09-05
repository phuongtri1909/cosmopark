<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class BannerPage extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'key',
        'title',
        'image',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public $translatable = [
        'title'
    ];

    /**
     * Scope for active banner pages
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered banner pages
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get all active banner pages
     */
    public static function getActiveBannerPages()
    {
        return static::active()->ordered()->get();
    }

    /**
     * Get banner page by key
     */
    public static function findByKey($key)
    {
        return static::where('key', $key)->first();
    }

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return asset('assets/images/dev/banner-default.jpg');
    }

    /**
     * Get banner page for specific page
     */
    public static function getBannerForPage($pageKey)
    {
        return static::where('key', $pageKey)->where('is_active', true)->first();
    }
}