<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BannerPage;

class BannerPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bannerPages = [
            [
                'key' => 'contact',
                'title' => [
                    'vi' => 'Liên hệ',
                    'en' => 'Contact'
                ],
                'image' => null,
                'is_active' => true,
                'sort_order' => 1
            ],
            [
                'key' => 'news',
                'title' => [
                    'vi' => 'Tin tức',
                    'en' => 'News'
                ],
                'image' => null,
                'is_active' => true,
                'sort_order' => 2
            ],
            [
                'key' => 'gallery',
                'title' => [
                    'vi' => 'Thư viện ảnh',
                    'en' => 'Gallery'
                ],
                'image' => null,
                'is_active' => true,
                'sort_order' => 3
            ]
        ];

        foreach ($bannerPages as $bannerPageData) {
            BannerPage::updateOrCreate(
                ['key' => $bannerPageData['key']],
                $bannerPageData
            );
        }
    }
}
