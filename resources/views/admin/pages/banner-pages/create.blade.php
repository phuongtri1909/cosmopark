@extends('admin.layouts.sidebar')

@section('title', 'Thêm Banner Trang')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.banner-pages.index') }}">Banner Trang</a></li>
                <li class="breadcrumb-item current">Thêm mới</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-plus icon-title"></i>
                    <h5>Thêm Banner Trang mới</h5>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.banner-pages.store') }}" method="POST" class="banner-page-form" enctype="multipart/form-data">
                    @csrf
                    @if($currentPage)
                        <input type="hidden" name="page" value="{{ $currentPage }}">
                    @endif

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="key" class="form-label">Trang <span class="required">*</span></label>
                            <select name="key" id="key" class="form-control" required>
                                <option value="">Chọn trang</option>
                                <option value="contact" {{ old('key', $currentPage) == 'contact' ? 'selected' : '' }}>Liên hệ</option>
                                <option value="news" {{ old('key', $currentPage) == 'news' ? 'selected' : '' }}>Tin tức</option>
                                <option value="gallery" {{ old('key', $currentPage) == 'gallery' ? 'selected' : '' }}>Thư viện ảnh</option>
                            </select>
                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>Chọn trang để quản lý banner.</span>
                            </div>
                            @error('key')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="sort_order" class="form-label">Thứ tự</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control"
                                value="{{ old('sort_order', 0) }}" min="0">
                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>Số càng nhỏ càng hiển thị trước.</span>
                            </div>
                            @error('sort_order')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="image" class="form-label">Ảnh banner</label>
                        <input type="file" name="image" id="image" class="form-control" accept="image/*">
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i>
                            <span>Hỗ trợ: jpeg, png, jpg, gif, webp. Tối đa 10MB.</span>
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
                                    value="{{ old('title.vi') }}" placeholder="Nhập tiêu đề tiếng Việt" required>
                                @error('title.vi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="lang-field">
                                <label class="lang-label">English</label>
                                <input type="text" name="title[en]" class="form-control"
                                    value="{{ old('title.en') }}" placeholder="Enter English title" required>
                                @error('title.en')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Hiển thị</label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.banner-pages.index', ['page' => $currentPage]) }}" class="back-button">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="save-button">
                            <i class="fas fa-save"></i> Lưu
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
    </style>
@endpush