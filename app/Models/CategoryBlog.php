<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CategoryBlog extends Model
{


    use HasTranslations;

    public $translatable = ['name', 'description'];

    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function blog()
    {
        return $this->hasMany(Blog::class, 'category_blog_id');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
