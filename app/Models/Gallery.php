<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'image_1',
        'image_2', 
        'image_3',
        'image_4',
        'image_5',
        'title',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Get all images as array
     */
    public function getAllImagesAttribute()
    {
        $images = [];
        for ($i = 1; $i <= 5; $i++) {
            $imageField = "image_{$i}";
            if ($this->$imageField) {
                $images[] = asset('storage/' . $this->$imageField);
            }
        }
        return $images;
    }

    /**
     * Get main image (first image)
     */
    public function getMainImageUrlAttribute()
    {
        if ($this->image_1) {
            return asset('storage/' . $this->image_1);
        }
        return asset('assets/images/default/image-default.jpg');
    }

    /**
     * Get sub images (images 2-5)
     */
    public function getSubImagesAttribute()
    {
        $subImages = [];
        for ($i = 2; $i <= 5; $i++) {
            $imageField = "image_{$i}";
            if ($this->$imageField) {
                $subImages[] = asset('storage/' . $this->$imageField);
            }
        }
        return $subImages;
    }

    /**
     * Scope for active galleries
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered galleries
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get the project that owns the gallery
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Scope for galleries by project
     */
    public function scopeByProject($query, $projectId)
    {
        return $query->where('project_id', $projectId);
    }
}