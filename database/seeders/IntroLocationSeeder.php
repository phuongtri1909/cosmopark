<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\IntroLocation;
use App\Models\IntroLocationStat;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class IntroLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (!Storage::disk('public')->exists('intro-locations')) {
            Storage::disk('public')->makeDirectory('intro-locations');
        }

        $sourceImage = public_path('assets/images/dev/intro-location.jpg');
        if (File::exists($sourceImage)) {
            $destinationPath = 'intro-locations/intro-location.jpg';
            Storage::disk('public')->put($destinationPath, File::get($sourceImage));
        }

        $introLocation = IntroLocation::create([
            'title' => [
                'vi' => 'TAY NINH NEW KEY ECONOMIC REGION',
                'en' => 'TAY NINH NEW KEY ECONOMIC REGION'
            ],
            'description' => [
                'vi' => 'Tây Ninh là tỉnh có vị trí chiến lược quan trọng, nằm trong vùng kinh tế trọng điểm phía Nam, có tiềm năng phát triển kinh tế lớn với nhiều lợi thế về địa lý, tài nguyên và con người.',
                'en' => 'Tay Ninh is a province with important strategic position, located in the key economic region of the South, with great economic development potential with many advantages in geography, resources and human resources.'
            ],
            'image' => 'intro-locations/intro-location.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Create stats
        $stats = [
            [
                'label' => ['vi' => 'Dân số', 'en' => 'Population'],
                'value' => ['vi' => '3,2', 'en' => '3.2'],
                'unit' => ['vi' => 'Triệu', 'en' => 'Million']
            ],
            [
                'label' => ['vi' => 'Quy mô kinh tế', 'en' => 'Economic Scale'],
                'value' => ['vi' => '~$13,5', 'en' => '~$13.5'],
                'unit' => ['vi' => 'Tỷ', 'en' => 'Billion']
            ],
            [
                'label' => ['vi' => 'Tốc độ tăng trưởng GRDP', 'en' => 'GRDP Growth Rate'],
                'value' => ['vi' => '9,63', 'en' => '9.63'],
                'unit' => ['vi' => '%', 'en' => '%']
            ],
            [
                'label' => ['vi' => 'GRDP bình quân đầu người', 'en' => 'GRDP per capita'],
                'value' => ['vi' => '120', 'en' => '120'],
                'unit' => ['vi' => 'Triệu', 'en' => 'Million']
            ],
            [
                'label' => ['vi' => 'FDI', 'en' => 'FDI'],
                'value' => ['vi' => '$24+', 'en' => '$24+'],
                'unit' => ['vi' => 'Tỷ', 'en' => 'Billion']
            ],
            [
                'label' => ['vi' => 'Kim ngạch xuất nhập khẩu', 'en' => 'Import Export Turnover'],
                'value' => ['vi' => '$13.9+', 'en' => '$13.9+'],
                'unit' => ['vi' => 'Tỷ', 'en' => 'Billion']
            ]
        ];

        foreach ($stats as $index => $stat) {
            IntroLocationStat::create([
                'intro_location_id' => $introLocation->id,
                'label' => $stat['label'],
                'value' => $stat['value'],
                'unit' => $stat['unit'],
                'sort_order' => $index
            ]);
        }
    }
} 