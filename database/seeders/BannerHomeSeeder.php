<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BannerHome;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BannerHomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Danh sách ảnh cũ từ thư mục dev
        $oldImages = [
            'assets/images/dev/hero-slider.jpg',
            'assets/images/dev/hero-slider-1.jpg',
            'assets/images/dev/hero-slider-2.webp',
        ];

        $bannerHomes = [];

        foreach ($oldImages as $index => $oldImagePath) {
            $sortOrder = $index + 1;
            
            if (File::exists(public_path($oldImagePath))) {
                $extension = pathinfo($oldImagePath, PATHINFO_EXTENSION);
                $newFileName = 'hero-slider-' . $sortOrder . '.' . $extension;
                $newPath = 'banner-homes/' . $newFileName;
                
                try {
                    $oldFileContent = File::get(public_path($oldImagePath));
                    
                    Storage::disk('public')->put($newPath, $oldFileContent);
                    
                    $bannerHomes[] = [
                        'image' => $newPath,
                        'sort_order' => $sortOrder,
                        'is_active' => true,
                    ];
                    
                    $this->command->info("Đã copy: {$oldImagePath} -> {$newPath}");
                    
                } catch (\Exception $e) {
                    $this->command->error("Lỗi khi copy file {$oldImagePath}: " . $e->getMessage());
                }
            } else {
                $this->command->warn("File không tồn tại: {$oldImagePath}");
            }
        }

        foreach ($bannerHomes as $bannerHomeData) {
            try {
                BannerHome::create($bannerHomeData);
                $this->command->info("Đã tạo banner: " . $bannerHomeData['image']);
            } catch (\Exception $e) {
                $this->command->error("Lỗi khi tạo banner: " . $e->getMessage());
            }
        }

        $this->command->info("Hoàn thành! Đã tạo " . count($bannerHomes) . " banner từ ảnh cũ.");
    }
} 