<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Industry;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class IndustrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $storagePath = 'industries';
        if (!Storage::disk('public')->exists($storagePath)) {
            Storage::disk('public')->makeDirectory($storagePath);
        }

        $sourcePath = public_path('assets/images/svg');
        $targetPath = storage_path('app/public/industries');

        $icon1 = $this->copyIconFile($sourcePath, $targetPath, 'branch-1.svg');
        Industry::create([
            'name' => [
                'vi' => 'THIẾT BỊ ĐIỆN TỬ',
                'en' => 'ELECTRICAL ELECTRONIC EQUIPMENT'
            ],
            'description' => [
                'vi' => 'Chuyên sản xuất và lắp ráp các thiết bị điện tử, điện lạnh, công nghệ thông tin',
                'en' => 'Specialized in manufacturing and assembling electronic devices, electrical appliances, and information technology equipment'
            ],
            'icon' => $icon1,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $icon2 = $this->copyIconFile($sourcePath, $targetPath, 'branch-2.svg');
        Industry::create([
            'name' => [
                'vi' => 'DƯỢC PHẨM',
                'en' => 'PHARMACEUTICALS'
            ],
            'description' => [
                'vi' => 'Nghiên cứu, sản xuất và phân phối các sản phẩm dược phẩm, thực phẩm chức năng',
                'en' => 'Research, manufacture and distribution of pharmaceutical products and functional foods'
            ],
            'icon' => $icon2,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $icon3 = $this->copyIconFile($sourcePath, $targetPath, 'branch-3.svg');
        Industry::create([
            'name' => [
                'vi' => 'NĂNG LƯỢNG',
                'en' => 'ENERGY'
            ],
            'description' => [
                'vi' => 'Phát triển các nguồn năng lượng tái tạo, năng lượng xanh và tiết kiệm năng lượng',
                'en' => 'Development of renewable energy sources, green energy and energy efficiency'
            ],
            'icon' => $icon3,
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $icon4 = $this->copyIconFile($sourcePath, $targetPath, 'branch-4.svg');
        Industry::create([
            'name' => [
                'vi' => 'CÁC NGÀNH KHÁC',
                'en' => 'AND OTHER INDUSTRIES'
            ],
            'description' => [
                'vi' => 'Bao gồm các ngành công nghiệp khác như cơ khí, hóa chất, vật liệu xây dựng',
                'en' => 'Including other industries such as mechanical engineering, chemicals, construction materials'
            ],
            'icon' => $icon4,
            'sort_order' => 4,
            'is_active' => true,
        ]);
    }


    private function copyIconFile($sourcePath, $targetPath, $filename)
    {
        $sourceFile = $sourcePath . '/' . $filename;
        $targetFile = $targetPath . '/' . $filename;

        if (File::exists($sourceFile)) {
            File::copy($sourceFile, $targetFile);
            
            return 'industries/' . $filename;
        }

        return null;
    }
} 