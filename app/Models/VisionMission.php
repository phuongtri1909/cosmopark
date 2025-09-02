<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class VisionMission extends Model
{
    use HasFactory, HasTranslations;

    protected $fillable = [
        'title',
        'description',
        'type',
        'is_active',
        'sort_order'
    ];

    const TYPE_VISION = 'vision';
    const TYPE_MISSION = 'mission';

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    public $translatable = [
        'title',
        'description'
    ];

    /**
     * Scope for active vision/mission
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered vision/mission
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Scope for vision type
     */
    public function scopeVision($query)
    {
        return $query->where('type', self::TYPE_VISION);
    }

    /**
     * Scope for mission type
     */
    public function scopeMission($query)
    {
        return $query->where('type', self::TYPE_MISSION);
    }

    /**
     * Get active vision
     */
    public static function getActiveVision()
    {
        return static::active()->vision()->ordered()->first();
    }

    /**
     * Get active mission
     */
    public static function getActiveMission()
    {
        return static::active()->mission()->ordered()->first();
    }

    /**
     * Get both active vision and mission
     */
    public static function getActiveVisionMission()
    {
        return [
            'vision' => static::getActiveVision(),
            'mission' => static::getActiveMission()
        ];
    }
} 