<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ImageHome;
use App\Models\ImageHomeSub;

class ImageHomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample image homes
        $imageHomes = [
            [
                'main_image' => 'assets/images/dev/image-1.jpg',
                'title' => 'COSMOPARK - Dự án phát triển bền vững',
                'sort_order' => 0,
                'is_active' => true,
                'sub_images' => [
                    'assets/images/dev/image-2.jpg',
                    'assets/images/dev/image-3.jpg',
                    'assets/images/dev/image-4.jpg',
                    'assets/images/dev/image-5.jpg'
                ]
            ],
            [
                'main_image' => 'assets/images/dev/intro-project.jpg',
                'title' => 'Khu công nghiệp sinh thái tiên tiến',
                'sort_order' => 1,
                'is_active' => true,
                'sub_images' => [
                    'assets/images/dev/intro-project-1.jpg',
                    'assets/images/dev/intro-project-2.webp',
                    'assets/images/dev/intro-project-3.jpg',
                    'assets/images/dev/feature-1.png'
                ]
            ]
        ];

        foreach ($imageHomes as $imageHomeData) {
            $subImages = $imageHomeData['sub_images'];
            unset($imageHomeData['sub_images']);
            
            $imageHome = ImageHome::create($imageHomeData);
            
            // Create sub images
            foreach ($subImages as $index => $subImage) {
                ImageHomeSub::create([
                    'image_home_id' => $imageHome->id,
                    'sub_image' => $subImage,
                    'sort_order' => $index
                ]);
            }
        }
    }
} 