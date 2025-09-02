<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Feature;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Storage::disk('public')->exists('features')) {
            Storage::disk('public')->makeDirectory('features');
        }

        // Copy sample images
        $sampleImages = [
            'feature-1.png',
            'feature-2.png', 
            'feature-3.png',
            'feature-4.png',
            'feature-5.png'
        ];

        foreach ($sampleImages as $image) {
            $sourceImage = public_path("assets/images/dev/{$image}");
            if (File::exists($sourceImage)) {
                $destinationPath = "features/{$image}";
                Storage::disk('public')->put($destinationPath, File::get($sourceImage));
            }
        }

        // Tạo 5 features mẫu
        $features = [
            [
                'image' => 'features/feature-1.png',
                'title' => [
                    'vi' => 'VỊ TRÍ CHIẾN LƯỢC',
                    'en' => 'STRATEGIC LOCATION'
                ],
                'description' => [
                    'vi' => 'Nằm tại vị trí đắc địa, dễ dàng tiếp cận các tuyến đường giao thông chính và cảng biển quốc tế.',
                    'en' => 'Located in a prime position with easy access to major transportation routes and international seaports.'
                ],
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'image' => 'features/feature-2.png',
                'title' => [
                    'vi' => 'HẠ TẦNG ĐỒNG BỘ',
                    'en' => 'SYNCHRONIZED INFRASTRUCTURE'
                ],
                'description' => [
                    'vi' => 'Hệ thống hạ tầng hiện đại, đồng bộ từ điện, nước, viễn thông đến giao thông nội bộ.',
                    'en' => 'Modern, synchronized infrastructure system from electricity, water, telecommunications to internal transportation.'
                ],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'image' => 'features/feature-3.png',
                'title' => [
                    'vi' => 'ƯU ĐÃI CHÍNH PHỦ',
                    'en' => 'GOVERNMENT INCENTIVES'
                ],
                'description' => [
                    'vi' => 'Hưởng các chính sách ưu đãi thuế, hỗ trợ đầu tư từ chính phủ và địa phương.',
                    'en' => 'Enjoy tax incentives and investment support policies from government and local authorities.'
                ],
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'image' => 'features/feature-4.png',
                'title' => [
                    'vi' => 'TIỆN ÍCH HOÀN CHỈNH',
                    'en' => 'COMPLETE AMENITIES'
                ],
                'description' => [
                    'vi' => 'Hệ thống tiện ích đầy đủ bao gồm nhà hàng, khách sạn, trung tâm thương mại và dịch vụ y tế.',
                    'en' => 'Complete amenities system including restaurants, hotels, shopping centers and medical services.'
                ],
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'image' => 'features/feature-5.png',
                'title' => [
                    'vi' => 'PHÁT TRIỂN SINH THÁI BỀN VỮNG',
                    'en' => 'SUSTAINABLE ECOLOGICAL DEVELOPMENT'
                ],
                'description' => [
                    'vi' => 'Cam kết phát triển bền vững với môi trường, sử dụng năng lượng xanh và công nghệ thân thiện.',
                    'en' => 'Commitment to sustainable environmental development using green energy and eco-friendly technology.'
                ],
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($features as $feature) {
            Feature::create($feature);
        }
    }
} 