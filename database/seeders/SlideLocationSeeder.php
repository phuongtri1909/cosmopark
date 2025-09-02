<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SlideLocation;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SlideLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Storage::disk('public')->exists('slide-locations')) {
            Storage::disk('public')->makeDirectory('slide-locations');
        }

        $sourceImage = public_path('assets/images/dev/location.png');
        if (File::exists($sourceImage)) {
            $destinationPath = 'slide-locations/location.png';
            Storage::disk('public')->put($destinationPath, File::get($sourceImage));
        }

        // Tạo 3 slide mẫu
        $slides = [
            [
                'image' => 'slide-locations/location.png',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'image' => 'slide-locations/location.png',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'image' => 'slide-locations/location.png',
                'sort_order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slides as $slide) {
            SlideLocation::create($slide);
        }
    }
} 