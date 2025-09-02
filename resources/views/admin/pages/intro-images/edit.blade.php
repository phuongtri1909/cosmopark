@extends('admin.layouts.sidebar')

@section('title', 'Chỉnh sửa ảnh giới thiệu')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.intro-images.index') }}">Ảnh giới thiệu</a></li>
                <li class="breadcrumb-item current">Chỉnh sửa</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-edit icon-title"></i>
                    <h5>Chỉnh sửa ảnh giới thiệu</h5>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.intro-images.update', $introImage) }}" method="POST" class="intro-image-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="image" class="form-label">Ảnh giới thiệu</label>
                            <div class="image-upload-container">
                                <div class="image-upload-preview" id="image-preview">
                                    @if($introImage->image)
                                        <img src="{{ asset('storage/' . $introImage->image) }}" alt="Ảnh hiện tại">
                                        <div class="image-overlay">
                                            <button type="button" class="remove-image-btn" id="remove-image">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div class="upload-placeholder">
                                            <i class="fas fa-cloud-upload-alt"></i>
                                            <span class="upload-text">Chọn ảnh</span>
                                        </div>
                                    @endif
                                </div>
                                <input type="file" name="image" id="image-upload" class="image-upload-input"
                                    accept="image/*">
                            </div>
                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>Kích thước đề xuất: 1200x800px. Để trống để giữ ảnh hiện tại.</span>
                            </div>
                            @error('image')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="sort_order" class="form-label">Thứ tự</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control"
                                value="{{ old('sort_order', $introImage->sort_order) }}" min="0">
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
                        <label class="form-label">Tiêu đề <span class="required">*</span></label>
                        <div class="language-fields">
                            <div class="lang-field">
                                <label class="lang-label">Tiếng Việt</label>
                                <input type="text" name="title[vi]" class="form-control"
                                    value="{{ old('title.vi', $introImage->getTranslation('title', 'vi')) }}" 
                                    placeholder="Nhập tiêu đề tiếng Việt" required>
                                @error('title.vi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="lang-field">
                                <label class="lang-label">English</label>
                                <input type="text" name="title[en]" class="form-control"
                                    value="{{ old('title.en', $introImage->getTranslation('title', 'en')) }}" 
                                    placeholder="Enter English title" required>
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
                                    placeholder="Nhập mô tả tiếng Việt" required>{{ old('description.vi', $introImage->getTranslation('description', 'vi')) }}</textarea>
                                @error('description.vi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="lang-field">
                                <label class="lang-label">English</label>
                                <textarea name="description[en]" class="form-control" rows="4"
                                    placeholder="Enter English description" required>{{ old('description.en', $introImage->getTranslation('description', 'en')) }}</textarea>
                                @error('description.en')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                {{ old('is_active', $introImage->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Hiển thị ảnh giới thiệu</label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.intro-images.index') }}" class="back-button">
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

        .image-upload-container {
            margin-bottom: 10px;
        }

        .image-upload-preview {
            width: 100%;
            height: 200px;
            border: 2px dashed #ddd;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .image-upload-preview:hover {
            border-color: #007bff;
        }

        .upload-placeholder {
            text-align: center;
            color: #666;
        }

        .upload-placeholder i {
            font-size: 48px;
            margin-bottom: 10px;
            display: block;
        }

        .image-upload-preview img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-upload-preview:hover .image-overlay {
            opacity: 1;
        }

        .remove-image-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        .remove-image-btn:hover {
            background: #c82333;
        }

        .image-upload-input {
            display: none;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Image upload preview
            $('#image-upload').change(function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#image-preview').html(`
                            <img src="${e.target.result}" alt="Preview">
                            <div class="image-overlay">
                                <button type="button" class="remove-image-btn" id="remove-image">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `);
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Click to select image
            $('#image-preview').click(function(e) {
                if (!$(e.target).closest('.remove-image-btn').length) {
                    $('#image-upload').click();
                }
            });

            // Remove image
            $(document).on('click', '#remove-image', function() {
                $('#image-upload').val('');
                $('#image-preview').html(`
                    <div class="upload-placeholder">
                        <i class="fas fa-cloud-upload-alt"></i>
                        <span class="upload-text">Chọn ảnh</span>
                    </div>
                `);
            });
        });
    </script>
@endpush 