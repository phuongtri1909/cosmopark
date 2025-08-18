@extends('client.layouts.app')
{{-- @section('title', $blog->title . ' - Ichor Shop')
@section('description', Str::limit(strip_tags($blog->content), 160))
@section('keywords', implode(', ', $blog->categories->pluck('name')->toArray()) . ', blog, fashion, style') --}}



@section('content')
    <section class="pt-5">
        <div class="container py-5  mt-4">
            <div class="row">

                <div class="col-lg-9 col-12 ">
                    <div class="d-flex align-items-start flex-column align-items-md-center flex-md-row">
                        <h2 class="text-1lg-2 text-black fw-bold me-3">Công ty Coca‑Cola khánh thành nhà máy 136 triệu USD
                            tại Tây Ninh</h2>
                        <span class="rounded-5 color-text-secondary bg-primary-11 px-3 py-2">Productivity</span>
                    </div>

                    <div
                        class="mt-3 mt-md-4 d-flex justify-content-between align-items-start align-items-md-center flex-column flex-md-row">
                        <div class="d-flex">
                            <img class="avatar me-3" src="{{ asset('assets/images/default/avatar_default.jpg') }}"
                                alt="avatar">
                            <div class="d-flex flex-column">
                                <span class="color-primary-8 text-md fw-semibold">Nguyễn Văn A</span>
                                <span class="color-text-secondary text-sm">2 mins read</span>
                            </div>
                        </div>
                        <div class="mt-3 mt-md-0">
                            <span class="rounded-5 color-text-secondary bg-primary-12 px-3 py-1 me-2 text-xs-1">
                                <img src="{{ asset('assets/images/svg/clock.svg') }}" alt="clock">
                                12 giờ trước
                            </span>
                            <span class="rounded-5 color-text-secondary bg-primary-12 px-3 py-1 text-xs-1">
                                <img src="{{ asset('assets/images/svg/eye.svg') }}" alt="eye">
                                15 lượt xem
                            </span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <img class="img-fluid rounded-4" src="{{ asset('assets/images/dev/hero-slider-1.jpg') }}"
                            alt="">

                        <div class="content-news mt-4">
                            <p class="text-md color-text-secondary">
                                Ngày 20/10, Công ty TNHH La Vie (Công ty TNHH La Vie) đã chính thức khánh thành nhà máy nước
                                khoáng thiên nhiên La Vie tại Tây Ninh với tổng vốn đầu tư 136 triệu USD.
                            </p>
                            <p class="text-md color-text-secondary">
                                Nhà máy được xây dựng trên diện tích 6,5 ha tại Khu công nghiệp Thái Hòa, huyện Đức Hòa,
                                tỉnh Tây Ninh. Đây là nhà máy thứ hai của La Vie tại Việt Nam, sau nhà máy đầu tiên được xây
                                dựng tại Hưng Yên vào năm 1992.
                            </p>
                            <p class="text-md color-text-secondary">
                                Nhà máy mới sẽ giúp La Vie tăng cường năng lực sản xuất và cung cấp nước khoáng thiên nhiên
                                cho thị trường Việt Nam, đáp ứng nhu cầu ngày càng cao của người tiêu dùng.
                            </p>
                        </div>
                    </div>


                </div>

                <div class="col-lg-3 col-12">
                    <h2 class="text-1lg-2 fw-bold color-primary-4 text-center text-md-start ">Mục lục</h2>

                    <div class="toc rounded p-3">
                        <ul class="list-unstyled mb-0">
                            <li class="toc-item active">
                                <a href="#gioi-thieu">Giới thiệu</a>
                            </li>
                            <li class="toc-item">
                                <a href="#features">Key Features of Coze AI</a>
                            </li>
                            <li class="toc-item">
                                <a href="#benefits">Benefits of Using Coze AI</a>
                            </li>
                            <li class="toc-item">
                                <a href="#conclusion">Conclusion</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-5">
                    <h2 class="text-1lg-2 fw-bold color-primary-4 text-center text-md-start ">Các bài viết khác</h2>
                    @php
                        $images = 6;
                    @endphp
                    <div class="row gx-1 g-3 mt-4">
                        @for ($index = 0; $index < $images; $index++)
                            <div class="col-12 col-md-6 col-lg-4">
                                <x-card-news />
                            </div>
                        @endfor
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection


@push('styles')
    <style>
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
        .toc-item {
            margin-bottom: 0.75rem;
            position: relative;
        }

        .toc-item a {
            text-decoration: none;
            color: var(--color-text-secondary);
            display: block;
            padding: 0.5rem 0.75rem;
            border-radius: 0.25rem;
            transition: all 0.2s;
        }

        .toc-item.active a {
            background: #f1f3f5;
            color: var( --primary-color-4);
            font-weight: 600;
        }

        .toc-item.active a::after {
            content: "";
            position: absolute;
            top: 0;
            right: 0;
            width: 4px;
            height: 100%;
            background: var( --primary-color-4);
            border-radius: 2px;
        }
    </style>
@endpush
@push('scripts')
@endpush
