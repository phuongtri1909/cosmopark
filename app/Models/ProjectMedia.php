<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectMedia extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'type', // images, plans, videos, street-views
        'file_path', // cho images, plans, street-views
        'video_url', // cho videos (YouTube link)
        'title',
        'description',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Scope for active media
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered media
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Scope for specific type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Get file URL for images, plans, street-views
     */
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return null;
    }

    /**
     * Get YouTube embed URL
     */
    public function getYouTubeEmbedUrlAttribute()
    {
        if ($this->video_url && $this->type === 'videos') {
            // Convert YouTube URL to embed URL
            $videoId = $this->extractYouTubeId($this->video_url);
            if ($videoId) {
                return "https://www.youtube.com/embed/{$videoId}";
            }
        }
        return null;
    }

    /**
     * Extract YouTube video ID from various URL formats
     */
    private function extractYouTubeId($url)
    {
        $patterns = [
            '/youtube\.com\/watch\?v=([^&]+)/',
            '/youtube\.com\/embed\/([^?]+)/',
            '/youtu\.be\/([^?]+)/',
            '/youtube\.com\/v\/([^?]+)/'
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }

    /**
     * Get thumbnail URL for YouTube videos
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->video_url && $this->type === 'videos') {
            $videoId = $this->extractYouTubeId($this->video_url);
            if ($videoId) {
                return "https://img.youtube.com/vi/{$videoId}/maxresdefault.jpg";
            }
        }
        return null;
    }

    /**
     * Relationship with Project
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
} 