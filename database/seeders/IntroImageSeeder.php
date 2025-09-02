<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IntroImage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class IntroImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Storage::disk('public')->exists('intro-images')) {
            Storage::disk('public')->makeDirectory('intro-images');
        }

        $sourceImage = public_path('assets/images/dev/image-6.jpg');
        if (File::exists($sourceImage)) {
            $destinationPath = 'intro-images/image-6.jpg';
            Storage::disk('public')->put($destinationPath, File::get($sourceImage));
        }

        // Tạo ảnh giới thiệu mẫu
        IntroImage::create([
            'title' => [
                'vi' => 'COSMOPARK',
                'en' => 'COSMOPARK'
            ],
            'description' => [
                'vi' => 'Khám phá không gian giải trí hiện đại với những trải nghiệm độc đáo và đáng nhớ.',
                'en' => 'Discover a modern entertainment space with unique and memorable experiences.'
            ],
            'image' => 'intro-images/image-6.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }
} 