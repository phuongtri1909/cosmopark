<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class IntroLocationStat extends Model
{
    use HasFactory, HasTranslations;

    public $translatable = ['label', 'value', 'unit'];

    protected $fillable = [
        'intro_location_id',
        'label',
        'value',
        'unit',
        'sort_order'
    ];

    protected $casts = [
        'sort_order' => 'integer'
    ];

    public function introLocation()
    {
        return $this->belongsTo(IntroLocation::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }
} 