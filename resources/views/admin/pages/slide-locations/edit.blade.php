@extends('admin.layouts.sidebar')

@section('title', 'Chỉnh sửa slide vị trí')

@section('main-content')
    <div class="category-form-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.slide-locations.index') }}">Slide vị trí</a></li>
                <li class="breadcrumb-item current">Chỉnh sửa</li>
            </ol>
        </div>

        <div class="form-card">
            <div class="form-header">
                <div class="form-title">
                    <i class="fas fa-edit icon-title"></i>
                    <h5>Chỉnh sửa slide vị trí</h5>
                    <small class="text-muted">(Dùng chung cho trang chủ và trang về chúng tôi)</small>
                </div>
                <div class="slide-location-meta">
                    <div class="slide-location-badge status {{ $slideLocation->is_active ? 'active' : 'inactive' }}">
                        <i class="fas fa-{{ $slideLocation->is_active ? 'check-circle' : 'times-circle' }}"></i>
                        <span>{{ $slideLocation->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}</span>
                    </div>
                    <div class="slide-location-badge created">
                        <i class="fas fa-calendar"></i>
                        <span>Ngày tạo: {{ $slideLocation->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="slide-location-badge order">
                        <i class="fas fa-sort"></i>
                        <span>Thứ tự: {{ $slideLocation->sort_order }}</span>
                    </div>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.slide-locations.update', $slideLocation) }}" method="POST" class="slide-location-form"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-tabs">
                        <!-- Ảnh và thông tin cơ bản -->
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="form-label-custom">
                                        Ảnh slide
                                    </label>
                                    <div class="slide-location-image-upload-container">
                                        <div class="image-preview-slide-location slide-location-image-preview {{ $slideLocation->image ? 'has-image' : '' }}"
                                            id="thumbnailPreview"
                                            style="background-image: url('{{ $slideLocation->image ? asset('storage/' . $slideLocation->image) : '' }}');">
                                            @if ($slideLocation->image)
                                                <span class="remove-image-btn" id="removeImage" title="Xóa ảnh">
                                                    <i class="fas fa-times"></i>
                                                </span>
                                            @endif
                                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                            <span class="upload-text">Chọn ảnh</span>
                                        </div>
                                        <input type="file" name="image" id="thumbnail-upload" class="image-upload-input"
                                            accept="image/*">
                                        <input type="hidden" name="remove_image" id="removeImageInput" value="0">
                                    </div>
                                    <div class="form-hint">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Kích thước đề xuất: 1200x800px. Để trống để giữ ảnh hiện tại.</span>
                                    </div>
                                    @error('image')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sort_order" class="form-label-custom">Thứ tự</label>
                                    <input type="number" class="custom-input" id="sort_order" name="sort_order"
                                        value="{{ old('sort_order', $slideLocation->sort_order) }}" min="0">
                                    @error('sort_order')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check-group">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="is_active" name="is_active" value="1"
                                            {{ old('is_active', $slideLocation->is_active) ? 'checked' : '' }}>
                                        <label for="is_active" class="form-label-custom mb-0">
                                            Hiển thị slide
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.slide-locations.index') }}" class="back-button">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="save-button">
                            <i class="fas fa-save"></i> Cập nhật slide
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .slide-location-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            margin-right: 10px;
            background-color: #f5f5f5;
        }

        .slide-location-badge i {
            margin-right: 5px;
        }

        .slide-location-badge.status.active {
            background-color: #e8f5e9;
            color: #2e7d32;
        }

        .slide-location-badge.status.inactive {
            background-color: #ffebee;
            color: #c62828;
        }

        .slide-location-badge.order {
            background-color: #e3f2fd;
            color: #1976d2;
        }

        .slide-location-image-upload-container {
            margin-top: 10px;
        }

        .image-preview-slide-location {
            width: 600px;
            height: 400px;
            border: 2px dashed #ddd;
            border-radius: 4px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            position: relative;
        }

        .image-preview-slide-location.has-image i,
        .image-preview-slide-location.has-image span {
            display: none;
        }

        .image-upload-input {
            display: none;
        }

        .upload-icon {
            font-size: 2rem;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .upload-text {
            color: #6c757d;
            font-size: 1rem;
        }

        .remove-image-btn {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(255, 255, 255, 0.8);
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #dc3545;
            cursor: pointer;
            z-index: 10;
        }

        .slide-location-meta {
            margin-top: 10px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Image upload preview
            $('#thumbnail-upload').change(function() {
                previewImage(this);
            });

            $('#thumbnailPreview').click(function() {
                $('#thumbnail-upload').click();
            });

            // Remove image functionality
            $('#removeImage').click(function(e) {
                e.stopPropagation();
                $('#thumbnailPreview').css('background-image', '');
                $('#thumbnailPreview').removeClass('has-image');
                $('#removeImageInput').val(1);
                $(this).remove();
            });

            function previewImage(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        $('#thumbnailPreview').css('background-image', `url('${e.target.result}')`);
                        $('#thumbnailPreview').addClass('has-image');
                        $('#removeImageInput').val(0);

                        // Add remove button if not exists
                        if ($('#removeImage').length === 0) {
                            $('#thumbnailPreview').append(
                                '<span class="remove-image-btn" id="removeImage" title="Xóa ảnh"><i class="fas fa-times"></i></span>'
                            );

                            // Bind click event for newly created button
                            $('#removeImage').click(function(e) {
                                e.stopPropagation();
                                $('#thumbnailPreview').css('background-image', '');
                                $('#thumbnailPreview').removeClass('has-image');
                                $('#removeImageInput').val(1);
                                $(this).remove();
                                $('#thumbnail-upload').val('');
                            });
                        }
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }
        });
    </script>
@endpush 