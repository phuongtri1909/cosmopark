<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GeneralIntroduction;

class GeneralIntroductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        GeneralIntroduction::create([
            'title' => [
                'vi' => 'COSMOPARK <br> TƯƠNG LAI. NGAY TẠI ĐÂY',
                'en' => 'COSMOPARK <br> THE FUTURE. HERE'
            ],
            'content' => [
                'vi' => 'COSMOPARK là dự án được đầu tư bởi Tập đoàn Hoàng Gia Việt Nam, với quy hoạch tổng thể là một tổ hợp công nghiệp và đô thị xanh, tuân thủ các tiêu chuẩn sinh thái, tích hợp sản xuất bền vững, logistics và không gian sống thân thiện với môi trường',
                'en' => 'COSMOPARK is a project invested by Hoang Gia Vietnam Group, with overall planning as a green industrial and urban complex, complying with ecological standards, integrating sustainable production, logistics and environmentally friendly living spaces'
            ],
            'is_active' => true,
        ]);
    }
} 