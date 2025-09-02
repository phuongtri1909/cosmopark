<?php

namespace App\Http\Controllers;

use App\Models\ImageHome;
use Illuminate\Http\Request;

class ImageHomeController extends Controller
{
    /**
     * Get image homes for AJAX request
     */
    public function getImageHomes()
    {
        $imageHomes = ImageHome::with(['subImages' => function($query) {
                $query->orderBy('sort_order', 'asc');
            }])
            ->active()
            ->ordered()
            ->get()
            ->map(function ($imageHome) {
                return [
                    'id' => $imageHome->id,
                    'main_image' => $imageHome->main_image_url,
                    'title' => $imageHome->title,
                    'sub_images' => $imageHome->subImages->map(function ($subImage) {
                        return [
                            'id' => $subImage->id,
                            'sub_image' => $subImage->sub_image_url,
                            'sort_order' => $subImage->sort_order
                        ];
                    })
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $imageHomes
        ]);
    }
} 