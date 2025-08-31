<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class IntroFeature extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['name', 'value', 'unit'];

    protected $fillable = [
        'name',
        'value',
        'unit',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer'
    ];

    /**
     * Scope for active features
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered features
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /**
     * Get the display value with unit
     */
    public function getDisplayValueAttribute()
    {
        return $this->value . ' ' . $this->unit;
    }
} 