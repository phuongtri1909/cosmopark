<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Project;
use App\Models\ProjectMedia;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Đảm bảo thư mục projects tồn tại
        $storagePath = 'projects';
        if (!Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->makeDirectory($storagePath);
        }

        // Copy hero images từ public sang storage
        $sourcePath = public_path('assets/images/dev');
        $targetPath = storage_path('app/public/projects');

        // 1. COSMOPARK ECO INDUSTRIAL ZONE
        $heroImage1 = $this->copyImageFile($sourcePath, $targetPath, 'intro-project.jpg');
        $project1 = Project::create([
            'slug' => 'cosmopark-eco-industrial-zone',
            'title' => [
                'vi' => 'COSMOPARK',
                'en' => 'COSMOPARK'
            ],
            'subtitle' => [
                'vi' => 'ECO INDUSTRIAL ZONE',
                'en' => 'ECO INDUSTRIAL ZONE'
            ],
            'description' => [
                'vi' => 'Khu công nghiệp sinh thái hiện đại với cơ sở hạ tầng đồng bộ, thân thiện môi trường',
                'en' => 'Modern eco-industrial zone with synchronized infrastructure, environmentally friendly'
            ],
            'number' => '822',
            'unit' => 'ha',
            'hero_image' => $heroImage1,
            'reverse_row' => false,
            'reverse_col' => false,
            'reverse_image' => false,
            'show_button' => false,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // 2. COSMOPARK CONVENIENT
        $heroImage2 = $this->copyImageFile($sourcePath, $targetPath, 'hero-slider-1.jpg');
        $project2 = Project::create([
            'slug' => 'cosmopark-convenient',
            'title' => [
                'vi' => 'COSMOPARK CONVENIENT',
                'en' => 'COSMOPARK CONVENIENT'
            ],
            'subtitle' => [
                'vi' => 'NHÀ Ở XÃ HỘI',
                'en' => 'SOCIAL HOUSING'
            ],
            'description' => [
                'vi' => 'Dự án nhà ở xã hội chất lượng cao, đáp ứng nhu cầu nhà ở cho người dân',
                'en' => 'High-quality social housing project, meeting housing needs for residents'
            ],
            'number' => '15',
            'unit' => 'ha',
            'hero_image' => $heroImage2,
            'reverse_row' => false,
            'reverse_col' => false,
            'reverse_image' => false,
            'show_button' => false,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        // 3. COSMO SOLAR PARK
        $heroImage3 = $this->copyImageFile($sourcePath, $targetPath, 'hero-slider-2.webp');
        $project3 = Project::create([
            'slug' => 'cosmo-solar-park',
            'title' => [
                'vi' => 'COSMO SOLAR PARK',
                'en' => 'COSMO SOLAR PARK'
            ],
            'subtitle' => [
                'vi' => '',
                'en' => ''
            ],
            'description' => [
                'vi' => 'Dự án năng lượng mặt trời quy mô lớn, góp phần phát triển năng lượng tái tạo',
                'en' => 'Large-scale solar energy project, contributing to renewable energy development'
            ],
            'number' => '500',
            'unit' => 'ha',
            'hero_image' => $heroImage3,
            'reverse_row' => false,
            'reverse_col' => true,
            'reverse_image' => true,
            'show_button' => false,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // 4. SÂN GOLF, RESORT & VILLA
        $heroImage4 = $this->copyImageFile($sourcePath, $targetPath, 'image-2.jpg');
        $project4 = Project::create([
            'slug' => 'san-golf-resort-villa',
            'title' => [
                'vi' => 'SÂN GOLF, RESORT & VILLA',
                'en' => 'GOLF COURSE, RESORT & VILLA'
            ],
            'subtitle' => [
                'vi' => '',
                'en' => ''
            ],
            'description' => [
                'vi' => 'Khu nghỉ dưỡng cao cấp với sân golf 18 lỗ, resort và biệt thự sang trọng',
                'en' => 'Luxury resort with 18-hole golf course, resort and luxury villas'
            ],
            'number' => '>120',
            'unit' => 'ha',
            'hero_image' => $heroImage4,
            'reverse_row' => false,
            'reverse_col' => true,
            'reverse_image' => true,
            'show_button' => true,
            'button_text' => [
                'vi' => 'Đặt ngay',
                'en' => 'Book now'
            ],
            'button_url' => 'https://royallongangolfandcountryclub.com/en/home/',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        // 5. COSMOPARK SMART AI CITY
        $heroImage5 = $this->copyImageFile($sourcePath, $targetPath, 'image-1.jpg');
        $project5 = Project::create([
            'slug' => 'cosmopark-smart-ai-city',
            'title' => [
                'vi' => 'COSMOPARK SMART AI CITY',
                'en' => 'COSMOPARK SMART AI CITY'
            ],
            'subtitle' => [
                'vi' => '',
                'en' => ''
            ],
            'description' => [
                'vi' => 'Thành phố thông minh ứng dụng AI, công nghệ tiên tiến cho cuộc sống hiện đại',
                'en' => 'Smart city with AI applications, advanced technology for modern life'
            ],
            'number' => '>1000',
            'unit' => 'ha',
            'hero_image' => $heroImage5,
            'reverse_row' => false,
            'reverse_col' => true,
            'reverse_image' => true,
            'show_button' => false,
            'sort_order' => 5,
            'is_active' => true,
        ]);

        // Tạo media mẫu cho từng project
        $this->createSampleMedia($project1);
        $this->createSampleMedia($project2);
        $this->createSampleMedia($project3);
        $this->createSampleMedia($project4);
        $this->createSampleMedia($project5);
    }

    /**
     * Copy image file từ source sang target và trả về đường dẫn tương đối
     */
    private function copyImageFile($sourcePath, $targetPath, $filename)
    {
        $sourceFile = $sourcePath . '/' . $filename;
        $targetFile = $targetPath . '/' . $filename;

        if (File::exists($sourceFile)) {
            File::copy($sourceFile, $targetFile);
            return 'projects/' . $filename;
        }

        return null;
    }

    /**
     * Tạo media mẫu cho project
     */
    private function createSampleMedia($project)
    {
        // Sample images
        $sampleImages = [
            'hero-slider-1.jpg',
            'hero-slider-2.webp',
            'hero-slider.jpg',
            'image-2.jpg',
            'image-3.jpg',
            'image-4.jpg',
            'image-5.jpg'
        ];

        foreach ($sampleImages as $index => $image) {
            $filePath = $this->copyImageFile(
                public_path('assets/images/dev'),
                storage_path('app/public/projects'),
                $image
            );

            if ($filePath) {
                ProjectMedia::create([
                    'project_id' => $project->id,
                    'type' => 'images',
                    'file_path' => $filePath,
                    'title' => 'Hình ảnh ' . ($index + 1),
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }

        // Sample plans
        $samplePlans = ['image-1.jpg', 'image-2.jpg', 'image-3.jpg'];
        foreach ($samplePlans as $index => $plan) {
            $filePath = $this->copyImageFile(
                public_path('assets/images/dev'),
                storage_path('app/public/projects'),
                $plan
            );

            if ($filePath) {
                ProjectMedia::create([
                    'project_id' => $project->id,
                    'type' => 'plans',
                    'file_path' => $filePath,
                    'title' => 'Kế hoạch ' . ($index + 1),
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }

        // Sample videos (YouTube links)
        $sampleVideos = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://www.youtube.com/watch?v=9bZkp7q19f0',
            'https://www.youtube.com/watch?v=kJQP7kiw5Fk'
        ];

        foreach ($sampleVideos as $index => $videoUrl) {
            ProjectMedia::create([
                'project_id' => $project->id,
                'type' => 'videos',
                'video_url' => $videoUrl,
                'title' => 'Video ' . ($index + 1),
                'sort_order' => $index + 1,
                'is_active' => true,
            ]);
        }

        // Sample street views
        $sampleStreetViews = ['image-4.jpg', 'image-5.jpg'];
        foreach ($sampleStreetViews as $index => $streetView) {
            $filePath = $this->copyImageFile(
                public_path('assets/images/dev'),
                storage_path('app/public/projects'),
                $streetView
            );

            if ($filePath) {
                ProjectMedia::create([
                    'project_id' => $project->id,
                    'type' => 'street-views',
                    'file_path' => $filePath,
                    'title' => 'Góc nhìn đường phố ' . ($index + 1),
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]);
            }
        }
    }
} 