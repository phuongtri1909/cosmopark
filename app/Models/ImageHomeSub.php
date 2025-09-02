<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageHomeSub extends Model
{
    use HasFactory;

    protected $fillable = [
        'image_home_id',
        'sub_image',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer'
    ];

    /**
     * Get the sub image URL attribute
     */
    public function getSubImageUrlAttribute()
    {
        if ($this->sub_image) {
            return asset('storage/' . $this->sub_image);
        }
        return asset('assets/images/default/image-default.jpg');
    }

    /**
     * Get the parent image home
     */
    public function imageHome()
    {
        return $this->belongsTo(ImageHome::class, 'image_home_id');
    }

    /**
     * Scope for ordered sub images
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
} 