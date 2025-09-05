@extends('admin.layouts.sidebar')

@section('title', 'Chỉnh sửa Banner Trang')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item current">Chỉnh sửa</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-edit icon-title"></i>
                    <h5>Chỉnh sửa Banner Trang - {{ ucfirst($pageKey) }}</h5>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.banner-pages.update', $bannerPage) }}" method="POST" class="banner-page-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="key" value="{{ $bannerPage->key }}">
                    @if($pageKey)
                        <input type="hidden" name="page" value="{{ $pageKey }}">
                    @endif

                    <div class="form-group">
                        <label class="form-label">Trang</label>
                        <div class="form-control-plaintext">
                            <strong>{{ $pageKey === 'contact' ? 'Liên hệ' : ($pageKey === 'news' ? 'Tin tức' : 'Thư viện ảnh') }}</strong>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">Ảnh banner</label>
                        @if ($bannerPage->image)
                            <div class="current-image mb-2">
                                <img src="{{ asset('storage/' . $bannerPage->image) }}" 
                                     alt="Current banner image" width="100" height="100" class="rounded">
                                <span class="ms-2 text-muted">Ảnh hiện tại</span>
                            </div>
                        @endif
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i>
                            <span>Hỗ trợ: jpeg, png, jpg, gif, webp. Tối đa 10MB. Để trống để giữ ảnh hiện tại.</span>
                        </div>
                        @error('image')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tiêu đề <span class="required">*</span></label>
                        <div class="language-fields">
                            <div class="lang-field">
                                <label class="lang-label">Tiếng Việt</label>
                                <input type="text" name="title[vi]" class="form-control"
                                    value="{{ old('title.vi', $bannerPage->getTranslation('title', 'vi')) }}" 
                                    placeholder="Nhập tiêu đề tiếng Việt" required>
                                @error('title.vi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="lang-field">
                                <label class="lang-label">English</label>
                                <input type="text" name="title[en]" class="form-control"
                                    value="{{ old('title.en', $bannerPage->getTranslation('title', 'en')) }}" 
                                    placeholder="Enter English title" required>
                                @error('title.en')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                {{ old('is_active', $bannerPage->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Hiển thị</label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.dashboard') }}" class="back-button">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="save-button">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .language-fields {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .lang-field {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background: #f8f9fa;
        }

        .lang-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .form-hint {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }

        .form-hint i {
            color: #007bff;
        }

        .form-check {
            margin-bottom: 0;
        }

        .form-check-label {
            margin-left: 8px;
            font-weight: 500;
        }

        .current-image {
            display: flex;
            align-items: center;
        }

        .current-image img {
            border: 1px solid #ddd;
        }
    </style>
@endpush