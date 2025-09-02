@extends('admin.layouts.sidebar')

@section('title', 'Thêm Feature mới')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.features.index') }}">Features</a></li>
                <li class="breadcrumb-item current">Thêm mới</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-plus icon-title"></i>
                    <h5>Thêm Feature mới</h5>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.features.store') }}" method="POST" enctype="multipart/form-data" class="feature-form">
                    @csrf

                    <div class="form-group">
                        <label for="image" class="form-label">Ảnh Feature <span class="required">*</span></label>
                        <div class="image-upload-wrapper">
                            <input type="file" name="image" id="image-upload" class="form-control" accept="image/*" required>
                            <div class="image-preview mt-2" id="image-preview" style="display: none;">
                                <img id="preview-img" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px;">
                            </div>
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

                    <div class="form-row">
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

                        <div class="form-group col-md-6">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                    {{ old('is_active') ? 'checked' : '' }}>
                                <label for="is_active" class="form-check-label">Hiển thị</label>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.features.index') }}" class="back-button">
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

        .image-upload-wrapper {
            border: 2px dashed #ddd;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background: #f8f9fa;
        }

        .image-preview {
            text-align: center;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Image upload preview
            $('#image-upload').change(function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#preview-img').attr('src', e.target.result);
                        $('#image-preview').show();
                    };
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    </script>
@endpush 