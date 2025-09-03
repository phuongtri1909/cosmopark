<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Project extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'slug',
        'title',
        'subtitle',
        'description',
        'number',
        'unit',
        'hero_image',
        'reverse_row',
        'reverse_col',
        'reverse_image',
        'show_button',
        'button_text',
        'button_url',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'reverse_row' => 'boolean',
        'reverse_col' => 'boolean',
        'reverse_image' => 'boolean',
        'show_button' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public $translatable = [
        'title',
        'subtitle',
        'description',
        'button_text'
    ];

    /**
     * Scope for active projects
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered projects
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get all active projects
     */
    public static function getActiveProjects()
    {
        return static::active()->ordered()->get();
    }

    /**
     * Get project by slug
     */
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->first();
    }

    /**
     * Get hero image URL
     */
    public function getHeroImageUrlAttribute()
    {
        if ($this->hero_image) {
            return asset('storage/' . $this->hero_image);
        }
        return asset('assets/images/dev/intro-project.jpg');
    }

    /**
     * Get project media
     */
    public function media()
    {
        return $this->hasMany(ProjectMedia::class);
    }

    /**
     * Get project images
     */
    public function images()
    {
        return $this->hasMany(ProjectMedia::class)->where('type', 'images');
    }

    /**
     * Get project plans
     */
    public function plans()
    {
        return $this->hasMany(ProjectMedia::class)->where('type', 'plans');
    }

    /**
     * Get project videos
     */
    public function videos()
    {
        return $this->hasMany(ProjectMedia::class)->where('type', 'videos');
    }

    /**
     * Get project street views
     */
    public function streetViews()
    {
        return $this->hasMany(ProjectMedia::class)->where('type', 'street-views');
    }
} 