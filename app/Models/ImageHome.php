<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageHome extends Model
{
    use HasFactory;

    protected $fillable = [
        'main_image',
        'title',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get the main image URL attribute
     */
    public function getMainImageUrlAttribute()
    {
        if ($this->main_image) {
            return asset('storage/' . $this->main_image);
        }
        return asset('assets/images/default/image-default.jpg');
    }

    /**
     * Get the sub images for this main image
     */
    public function subImages()
    {
        return $this->hasMany(ImageHomeSub::class, 'image_home_id')->orderBy('sort_order', 'asc');
    }

    /**
     * Scope for active images
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered images
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
} 