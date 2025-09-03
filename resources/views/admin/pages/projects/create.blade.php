@extends('admin.layouts.sidebar')

@section('title', 'Thêm Dự án')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Dự án</a></li>
                <li class="breadcrumb-item current">Thêm mới</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-plus icon-title"></i>
                    <h5>Thêm Dự án mới</h5>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.projects.store') }}" method="POST" class="project-form" enctype="multipart/form-data">
                    @csrf

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="slug" class="form-label">Slug <span class="required">*</span></label>
                            <input type="text" name="slug" id="slug" class="form-control"
                                value="{{ old('slug') }}" placeholder="cosmopark-eco-industrial-zone" required>
                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>URL friendly, không dấu, không khoảng trắng, dùng gạch ngang.</span>
                            </div>
                            @error('slug')
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

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="number" class="form-label">Số liệu <span class="required">*</span></label>
                            <input type="text" name="number" id="number" class="form-control"
                                value="{{ old('number') }}" placeholder="822" required>
                            @error('number')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="unit" class="form-label">Đơn vị <span class="required">*</span></label>
                            <input type="text" name="unit" id="unit" class="form-control"
                                value="{{ old('unit') }}" placeholder="ha" required>
                            @error('unit')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="hero_image" class="form-label">Ảnh chính</label>
                        <input type="file" name="hero_image" id="hero_image" class="form-control" accept="image/*">
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i>
                            <span>Hỗ trợ: jpeg, png, jpg, gif, webp. Tối đa 2MB.</span>
                        </div>
                        @error('hero_image')
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
                        <label class="form-label">Tiêu đề phụ</label>
                        <div class="language-fields">
                            <div class="lang-field">
                                <label class="lang-label">Tiếng Việt</label>
                                <input type="text" name="subtitle[vi]" class="form-control"
                                    value="{{ old('subtitle.vi') }}" placeholder="Nhập tiêu đề phụ tiếng Việt">
                                @error('subtitle.vi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="lang-field">
                                <label class="lang-label">English</label>
                                <input type="text" name="subtitle[en]" class="form-control"
                                    value="{{ old('subtitle.en') }}" placeholder="Enter English subtitle">
                                @error('subtitle.en')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mô tả <span class="required">*</span></label>
                        <div class="language-fields">
                            <div class="lang-field">
                                <label class="lang-label">Tiếng Việt</label>
                                <textarea name="description[vi]" class="form-control" rows="4"
                                    placeholder="Nhập mô tả tiếng Việt" required>{{ old('description.vi') }}</textarea>
                                @error('description.vi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="lang-field">
                                <label class="lang-label">English</label>
                                <textarea name="description[en]" class="form-control" rows="4"
                                    placeholder="Enter English description" required>{{ old('description.en') }}</textarea>
                                @error('description.en')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Layout</label>
                        <div class="layout-options">
                            <div class="form-check">
                                <input type="checkbox" name="reverse_row" id="reverse_row" class="form-check-input"
                                    {{ old('reverse_row') ? 'checked' : '' }}>
                                <label for="reverse_row" class="form-check-label">Đảo ngược thứ tự hàng</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="reverse_col" id="reverse_col" class="form-check-input"
                                    {{ old('reverse_col') ? 'checked' : '' }}>
                                <label for="reverse_col" class="form-check-label">Đảo ngược thứ tự cột</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="reverse_image" id="reverse_image" class="form-check-input"
                                    {{ old('reverse_image') ? 'checked' : '' }}>
                                <label for="reverse_image" class="form-check-label">Đảo ngược vị trí ảnh</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Button</label>
                        <div class="button-options">
                            <div class="form-check">
                                <input type="checkbox" name="show_button" id="show_button" class="form-check-input"
                                    {{ old('show_button') ? 'checked' : '' }}>
                                <label for="show_button" class="form-check-label">Hiển thị button</label>
                            </div>
                            
                            <div id="button-fields" class="mt-3" style="display: none;">
                                <div class="form-group">
                                    <label for="button_url" class="form-label">URL Button</label>
                                    <input type="url" name="button_url" id="button_url" class="form-control"
                                        value="{{ old('button_url') }}" placeholder="https://example.com">
                                    @error('button_url')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="language-fields">
                                    <div class="lang-field">
                                        <label class="lang-label">Tiếng Việt</label>
                                        <input type="text" name="button_text[vi]" class="form-control"
                                            value="{{ old('button_text.vi') }}" placeholder="Nhập text button tiếng Việt">
                                        @error('button_text.vi')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="lang-field">
                                        <label class="lang-label">English</label>
                                        <input type="text" name="button_text[en]" class="form-control"
                                            value="{{ old('button_text.en') }}" placeholder="Enter English button text">
                                        @error('button_text.en')
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
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
                        <a href="{{ route('admin.projects.index') }}" class="back-button">
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

        .layout-options, .button-options {
            display: flex;
            flex-direction: column;
            gap: 10px;
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const showButtonCheckbox = document.getElementById('show_button');
            const buttonFields = document.getElementById('button_fields');
            
            function toggleButtonFields() {
                if (showButtonCheckbox.checked) {
                    buttonFields.style.display = 'block';
                } else {
                    buttonFields.style.display = 'none';
                }
            }
            
            showButtonCheckbox.addEventListener('change', toggleButtonFields);
            toggleButtonFields(); // Initial state
        });
    </script>
@endpush 