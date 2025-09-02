<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VisionMission;

class VisionMissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Tạo Vision
        VisionMission::create([
            'title' => [
                'vi' => 'Tầm nhìn',
                'en' => 'Vision'
            ],
            'description' => [
                'vi' => 'Trở thành khu công nghiệp và đô thị xanh hàng đầu tại Việt Nam, tiên phong trong phát triển bền vững và bảo vệ môi trường.',
                'en' => 'To become the leading green industrial zone and urban area in Vietnam, pioneering sustainable development and environmental protection.'
            ],
            'type' => 'vision',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Tạo Mission
        VisionMission::create([
            'title' => [
                'vi' => 'Sứ mệnh',
                'en' => 'Mission'
            ],
            'description' => [
                'vi' => 'Xây dựng và phát triển một hệ sinh thái công nghiệp bền vững, kết hợp hài hòa giữa phát triển kinh tế và bảo vệ môi trường.',
                'en' => 'To build and develop a sustainable industrial ecosystem, harmoniously combining economic development with environmental protection.'
            ],
            'type' => 'mission',
            'sort_order' => 2,
            'is_active' => true,
        ]);
    }
} 