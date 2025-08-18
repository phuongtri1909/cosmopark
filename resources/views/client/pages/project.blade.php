@extends('client.layouts.app')
@section('title', 'Project - Cosmopark')
@section('description', 'Project - Cosmopark')
@section('keyword', 'Cosmopark, Project')


@section('content')

    @if ($slug == 'cosmopark-eco-industrial-zone')
        @php
            $reverseRow = false;
            $reverseCol = false;
            $reverseImage = false;
            $title = 'COSMOPARK';
            $subtitle = 'ECO INDUSTRIAL ZONE';
            $desc = 'Cosmopark Eco Industrial Zone Tây Ninh là khu công nghiệp sinh thái sở hữu lợi thế vượt trội, tọa
        lạc tại vùng kinh tế trọng điểm, năng động và phát triển bậc nhất cả nước.
        Phát triển theo mô hình công nghiệp sinh thái, lấy kinh tế tuần hoàn làm trọng tâm, giảm thiểu phát
        thải và sử dụng năng lượng sạch, Cosmopark hướng tới mục tiêu xây dựng nền công nghiệp hiện đại,
        thân thiện với môi trường. Tại khu vực miền Nam Việt Nam, đây là địa điểm lý tưởng để các doanh
        nghiệp và nhà đầu tư đặt nền móng phát triển công nghiệp bền vững.';
            $number = '822';
            $unit = 'ha';
            $image = asset('assets/images/dev/intro-project.jpg');
            $button = false;
        @endphp
    @elseif($slug == 'cosmopark-convenient')
        @php
            $reverseRow = false;
            $reverseCol = false;
            $reverseImage = false;
            $title = 'COSMOPARK CONVENIENT';
            $subtitle = '(NHÀ Ở XÃ HỘI)';
            $desc =
                'Khu nhà ở xã hội 4800 căn được quy hoạch đồng bộ, đáp ứng trực tiếp nhu cầu an cư thiết yếu của người lao động. Với thiết kế tối ưu, hệ thống tiện ích như: Công viên, trường học, bệnh viện,... dễ tiếp cận và hạ tầng giao thông kết nối nhanh chóng, dự án bảo đảm điều kiện sinh hoạt ổn định, nâng cao hiệu suất lao động. Đây là một phần quan trọng trong chiến lược của COSMOPARK nhằm xây dựng cộng đồng bền vững, phát triển hài hòa cùng tiến trình công nghiệp.';
            $number = '15';
            $unit = 'ha';
            $image = asset('assets/images/dev/hero-slider-1.jpg');
            $button = false;
        @endphp
    @elseif($slug == 'cosmo-solar-park')
        @php
            $reverseRow = false;
            $reverseCol = true;
            $reverseImage = true;
            $title = 'COSMO SOLAR PARK';
            $subtitle = '';
            $desc =
                'Cánh đồng điện năng lượng mặt trời tiên tiến quy mô lớn, bảo đảm cung cấp ổn định nguồn điện tái tạo cho toàn bộ dự án và góp phần giảm thiểu phát thải Carbon. Được vận hành hiệu quả từ năm 2019, đây là hạng mục then chốt trong chiến lược phát triển khu công nghiệp sinh thái bền vững của COSMOPARK.';
            $number = '500';
            $unit = 'ha';
            $image = asset('assets/images/dev/hero-slider-2.webp');
            $button = false;
        @endphp
    @elseif($slug == 'san-golf-resort-villa')
        @php
            $reverseRow = false;
            $reverseCol = true;
            $reverseImage = true;
            $title = 'SÂN GOLF, RESORT & VILLA';
            $subtitle = '';
            $desc =
                'Sân golf 27 lỗ tiêu chuẩn quốc tế đã đi vào vận hành, đồng bộ với khu nghỉ dưỡng, khách sạn, biệt thự và khu dân cư cao cấp đang triển khai. Không chỉ nâng cao giá trị dự án và khẳng định vị thế thương hiệu, mà còn tạo dựng một điểm đến cho chuyên gia, nhà đầu tư và cộng đồng doanh nghiệp, là nơi kết nối, nghỉ dưỡng và tận hưởng không gian sống xanh, đẳng cấp.';
            $number = '>120';
            $unit = 'ha';
            $image = asset('assets/images/dev/image-2.jpg');
            $button = true;
        @endphp
        @elseif($slug == 'cosmopark-smart-ai-city')
        @php
            $reverseRow = false;
            $reverseCol = true;
            $reverseImage = true;
            $title = 'COSMOPARK SMART AI CITY';
            $subtitle = '';
            $desc =
                'Khu đô thị thông minh ứng dụng trí tuệ nhân tạo, tích hợp toàn diện các tiện ích thương mại, giáo dục và giải trí trong một quy hoạch đồng bộ. Dự án bao gồm hệ thống trường liên cấp, đại học, trung tâm thương mại sầm uất, công viên giải trí chuyên đề, trường đua ngựa và bệnh viện đa khoa tiêu chuẩn quốc tế. Tất cả được vận hành bởi các đơn vị quản lý uy tín, đảm bảo hiệu suất khai thác tối ưu, tiện ích vượt trội và an ninh tuyệt đối 24/7. Đây là môi trường an cư, lập nghiệp lý tưởng cho giới chuyên gia, đồng thời là cộng đồng hướng tới mục tiêu phát triển thịnh vượng và bền vững.';
            $number = '>1000';
            $unit = 'ha';
            $image = asset('assets/images/dev/image-1.jpg');
            $button = true;
        @endphp
    @endif

    <x-intro-project :reverseRow="$reverseRow" :reverseCol="$reverseCol" :reverseImage="$reverseImage" :title="$title" :subtitle="$subtitle"
        :desc="$desc" :number="$number" :unit="$unit" :image="$image" :button="$button" />

    <x-media-project :images="[
        asset('assets/images/dev/hero-slider-1.jpg'),
        asset('assets/images/dev/hero-slider-2.webp'),
        asset('assets/images/dev/hero-slider.jpg'),
        asset('assets/images/dev/image-2.jpg'),
        asset('assets/images/dev/image-3.jpg'),
        asset('assets/images/dev/image-4.jpg'),
        asset('assets/images/dev/image-5.jpg'),
    ]" />

    @if ($slug == 'cosmopark-eco-industrial-zone')
        <x-location />
        <x-branch />
    @endif
@endsection

@push('scripts')
@endpush

@push('styles')
@endpush
