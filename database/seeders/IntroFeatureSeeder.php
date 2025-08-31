<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IntroFeature;

class IntroFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'name' => [
                    'vi' => 'Khu Công Nghiệp',
                    'en' => 'Industrial Zone'
                ],
                'value' => [
                    'vi' => '322',
                    'en' => '322'
                ],
                'unit' => [
                    'vi' => 'ha',
                    'en' => 'ha'
                ],
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => [
                    'vi' => 'Khu Nhà Ở Xã Hội',
                    'en' => 'Social Housing Area'
                ],
                'value' => [
                    'vi' => '15',
                    'en' => '15'
                ],
                'unit' => [
                    'vi' => 'ha',
                    'en' => 'ha'
                ],
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => [
                    'vi' => 'Khu Năng Lượng Mặt Trời',
                    'en' => 'Solar Energy Zone'
                ],
                'value' => [
                    'vi' => '500',
                    'en' => '500'
                ],
                'unit' => [
                    'vi' => 'ha',
                    'en' => 'ha'
                ],
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => [
                    'vi' => 'Sân Golf, Resort & Villa',
                    'en' => 'Golf Course, Resort & Villa'
                ],
                'value' => [
                    'vi' => '>120',
                    'en' => '>120'
                ],
                'unit' => [
                    'vi' => 'ha',
                    'en' => 'ha'
                ],
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => [
                    'vi' => 'Khu Thành Phố Thông Minh',
                    'en' => 'Smart City Zone'
                ],
                'value' => [
                    'vi' => '>1000',
                    'en' => '>1000'
                ],
                'unit' => [
                    'vi' => 'ha',
                    'en' => 'ha'
                ],
                'sort_order' => 5,
                'is_active' => true,
            ],
        ];

        foreach ($features as $feature) {
            IntroFeature::create($feature);
        }
    }
} 