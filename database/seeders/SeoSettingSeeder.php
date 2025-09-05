<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SeoSetting;

class SeoSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $seoSettings = [
            [
                'page_key' => 'home',
                'title' => [
                    'vi' => 'Trang chủ - Cosmopark',
                    'en' => 'Home - Cosmopark'
                ],
                'description' => [
                    'vi' => 'COSMOPARK là dự án được đầu tư bởi Tập đoàn Hoàng Gia Việt Nam, với quy hoạch tổng thể như một tổ hợp khu công nghiệp và đô thị xanh, tuân thủ các tiêu chuẩn sinh thái.',
                    'en' => 'COSMOPARK is a project invested by Hoang Gia Vietnam Group, with overall planning as a green industrial and urban complex, following ecological standards.'
                ],
                'keywords' => [
                    'vi' => 'Cosmopark, khu công nghiệp, đô thị xanh, phát triển bền vững, Việt Nam',
                    'en' => 'Cosmopark, industrial zone, green city, sustainable development, Vietnam'
                ],
                'is_active' => true
            ],
            [
                'page_key' => 'about',
                'title' => [
                    'vi' => 'Về chúng tôi - Cosmopark',
                    'en' => 'About Us - Cosmopark'
                ],
                'description' => [
                    'vi' => 'Tìm hiểu về Cosmopark, dự án khu công nghiệp và đô thị xanh tại Việt Nam, với cam kết phát triển bền vững và bảo vệ môi trường.',
                    'en' => 'Learn about Cosmopark, a green industrial and urban project in Vietnam, committed to sustainable development and environmental protection.'
                ],
                'keywords' => [
                    'vi' => 'Cosmopark, giới thiệu, về chúng tôi, khu công nghiệp, đô thị xanh',
                    'en' => 'Cosmopark, about us, introduction, industrial zone, green city'
                ],
                'is_active' => true
            ],
            [
                'page_key' => 'contact',
                'title' => [
                    'vi' => 'Liên hệ - Cosmopark',
                    'en' => 'Contact - Cosmopark'
                ],
                'description' => [
                    'vi' => 'Liên hệ với Cosmopark để được tư vấn và hỗ trợ thông tin về các dự án khu công nghiệp và đô thị xanh.',
                    'en' => 'Contact Cosmopark for consultation and support information about green industrial and urban projects.'
                ],
                'keywords' => [
                    'vi' => 'Cosmopark, liên hệ, tư vấn, hỗ trợ, thông tin dự án',
                    'en' => 'Cosmopark, contact, consultation, support, project information'
                ],
                'is_active' => true
            ],
            [
                'page_key' => 'gallery',
                'title' => [
                    'vi' => 'Hình ảnh - Cosmopark',
                    'en' => 'Gallery - Cosmopark'
                ],
                'description' => [
                    'vi' => 'Thư viện hình ảnh về các dự án và hoạt động của Cosmopark, khu công nghiệp và đô thị xanh hàng đầu Việt Nam.',
                    'en' => 'Image gallery of Cosmopark projects and activities, Vietnam\'s leading green industrial and urban complex.'
                ],
                'keywords' => [
                    'vi' => 'Cosmopark, hình ảnh, thư viện, dự án, hoạt động',
                    'en' => 'Cosmopark, images, gallery, projects, activities'
                ],
                'is_active' => true
            ],
            [
                'page_key' => 'news',
                'title' => [
                    'vi' => 'Tin tức - Cosmopark',
                    'en' => 'News - Cosmopark'
                ],
                'description' => [
                    'vi' => 'Cập nhật tin tức mới nhất về Cosmopark, các dự án khu công nghiệp và đô thị xanh, sự kiện và hoạt động cộng đồng.',
                    'en' => 'Latest news updates about Cosmopark, green industrial and urban projects, events and community activities.'
                ],
                'keywords' => [
                    'vi' => 'Cosmopark, tin tức, cập nhật, dự án, sự kiện, cộng đồng',
                    'en' => 'Cosmopark, news, updates, projects, events, community'
                ],
                'is_active' => true
            ],
            [
                'page_key' => 'projects',
                'title' => [
                    'vi' => 'Dự án - Cosmopark',
                    'en' => 'Projects - Cosmopark'
                ],
                'description' => [
                    'vi' => 'Khám phá các dự án của Cosmopark bao gồm khu công nghiệp sinh thái, đô thị thông minh và các dự án phát triển bền vững.',
                    'en' => 'Explore Cosmopark projects including eco-industrial zones, smart cities and sustainable development projects.'
                ],
                'keywords' => [
                    'vi' => 'Cosmopark, dự án, khu công nghiệp sinh thái, đô thị thông minh, phát triển bền vững',
                    'en' => 'Cosmopark, projects, eco-industrial zone, smart city, sustainable development'
                ],
                'is_active' => true
            ]
        ];

        foreach ($seoSettings as $setting) {
            SeoSetting::updateOrCreate(
                ['page_key' => $setting['page_key']],
                $setting
            );
        }
    }
}
