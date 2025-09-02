@extends('admin.layouts.sidebar')

@section('title', 'Thêm thông tin vị trí mới')

@section('main-content')
    <div class="category-form-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.intro-locations.index') }}">Thông tin vị trí</a></li>
                <li class="breadcrumb-item current">Thêm mới</li>
            </ol>
        </div>

        <div class="form-card">
            <div class="form-header">
                <div class="form-title">
                    <i class="fas fa-plus icon-title"></i>
                    <h5>Thêm thông tin vị trí mới</h5>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.intro-locations.store') }}" method="POST" class="intro-location-form"
                    enctype="multipart/form-data" id="intro-location-form">
                    @csrf

                    <div class="form-tabs">
                        <!-- Ảnh và thông tin cơ bản -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label-custom">
                                        Ảnh vị trí <span class="required-mark">*</span>
                                    </label>
                                    <div class="intro-location-image-upload-container">
                                        <div class="image-preview-intro-location intro-location-image-preview" id="thumbnailPreview">
                                            <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                            <span class="upload-text">Chọn ảnh</span>
                                        </div>
                                        <input type="file" name="image" id="thumbnail-upload" class="image-upload-input"
                                            accept="image/*">
                                    </div>
                                    <div class="form-hint">
                                        <i class="fas fa-info-circle"></i>
                                        <span>Kích thước đề xuất: 800x600px.</span>
                                    </div>
                                    <div class="error-message" id="error-image">
                                        @error('image')
                                            {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="sort_order" class="form-label-custom">Thứ tự</label>
                                    <input type="number" class="custom-input" id="sort_order" name="sort_order"
                                        value="{{ old('sort_order', 0) }}" min="0">
                                    @error('sort_order')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check-group">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="is_active" name="is_active" value="1"
                                            {{ old('is_active', '1') ? 'checked' : '' }}>
                                        <label for="is_active" class="form-label-custom mb-0">
                                            Hiển thị thông tin vị trí
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tiêu đề đa ngôn ngữ -->
                        <div class="row">
                            @foreach ($languages as $lang => $langName)
                                <div class="col-md-6 {{ !$loop->first ? 'mt-4 mt-md-0' : '' }}">
                                    <div class="form-group">
                                        <label for="title_{{ $lang }}">Tiêu đề ({{ $langName }}) <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title[{{ $lang }}]"
                                            id="title_{{ $lang }}"
                                            class="custom-input {{ $errors->has("title.$lang") ? 'input-error' : '' }}"
                                            value="{{ old("title.$lang") }}" maxlength="255">
                                        @error("title.$lang")
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Mô tả đa ngôn ngữ -->
                        <div class="row">
                            @foreach ($languages as $lang => $langName)
                                <div class="col-md-6 {{ !$loop->first ? 'mt-4 mt-md-0' : '' }}">
                                    <div class="form-group">
                                        <label for="description_{{ $lang }}">Mô tả ({{ $langName }}) <span
                                                class="text-danger">*</span></label>
                                        <textarea name="description[{{ $lang }}]" id="description_{{ $lang }}"
                                            class="custom-input {{ $errors->has("description.$lang") ? 'input-error' : '' }}" 
                                            rows="4" maxlength="1000">{{ old("description.$lang") }}</textarea>
                                        @error("description.$lang")
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Thống kê đa ngôn ngữ -->
                        <div class="stats-section">
                            <h5 class="mb-3">Thống kê</h5>
                            
                            <!-- Tiếng Việt -->
                            <div class="language-stats mb-4">
                                <h6 class="text-primary">Tiếng Việt</h6>
                                <div id="stats_vi_container">
                                    <div class="stat-item mb-3" data-index="0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="custom-input" name="stats[vi][0][label]" 
                                                       placeholder="Nhãn (VD: Dân số)" maxlength="100" required>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="custom-input" name="stats[vi][0][value]" 
                                                       placeholder="Giá trị (VD: 3,2)" maxlength="50" required>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="custom-input" name="stats[vi][0][unit]" 
                                                       placeholder="Đơn vị (VD: Triệu)" maxlength="20">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-stat" data-lang="vi">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm add-stat" data-lang="vi">
                                    <i class="fas fa-plus"></i> Thêm thống kê
                                </button>
                            </div>

                            <!-- English -->
                            <div class="language-stats">
                                <h6 class="text-primary">English</h6>
                                <div id="stats_en_container">
                                    <div class="stat-item mb-3" data-index="0">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <input type="text" class="custom-input" name="stats[en][0][label]" 
                                                       placeholder="Label (e.g., Population)" maxlength="100" required>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="custom-input" name="stats[en][0][value]" 
                                                       placeholder="Value (e.g., 3.2)" maxlength="50" required>
                                            </div>
                                            <div class="col-md-3">
                                                <input type="text" class="custom-input" name="stats[en][0][unit]" 
                                                       placeholder="Unit (e.g., Million)" maxlength="20">
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-danger btn-sm remove-stat" data-lang="en">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-success btn-sm add-stat" data-lang="en">
                                    <i class="fas fa-plus"></i> Add Statistic
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.intro-locations.index') }}" class="back-button">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="save-button">
                            <i class="fas fa-save"></i> Lưu thông tin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
let statIndexes = { vi: 1, en: 1 };

$(document).ready(function() {
    // Thêm thống kê mới
    $('.add-stat').click(function() {
        const lang = $(this).data('lang');
        const index = statIndexes[lang]++;
        
        const newStat = `
            <div class="stat-item mb-3" data-index="${index}">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="custom-input" name="stats[${lang}][${index}][label]" 
                               placeholder="${lang === 'vi' ? 'Nhãn' : 'Label'}" maxlength="100" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="custom-input" name="stats[${lang}][${index}][value]" 
                               placeholder="${lang === 'vi' ? 'Giá trị' : 'Value'}" maxlength="50" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="custom-input" name="stats[${lang}][${index}][unit]" 
                               placeholder="${lang === 'vi' ? 'Đơn vị' : 'Unit'}" maxlength="20">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-stat" data-lang="${lang}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        $(`#stats_${lang}_container`).append(newStat);
    });

    // Xóa thống kê
    $(document).on('click', '.remove-stat', function() {
        const lang = $(this).data('lang');
        const statItem = $(this).closest('.stat-item');
        
        if ($(`#stats_${lang}_container .stat-item`).length > 1) {
            statItem.remove();
        } else {
            alert('Phải có ít nhất 1 thống kê cho mỗi ngôn ngữ!');
        }
    });

    // Image upload preview
    $('#thumbnail-upload').change(function() {
        previewImage(this);
    });

    $('#thumbnailPreview').click(function() {
        $('#thumbnail-upload').click();
    });

    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                $('#thumbnailPreview').css('background-image', `url('${e.target.result}')`);
                $('#thumbnailPreview').addClass('has-image');

                // Add remove button if not exists
                if ($('#removeImage').length === 0) {
                    $('#thumbnailPreview').append(
                        '<span class="remove-image-btn" id="removeImage" title="Xóa ảnh"><i class="fas fa-times"></i></span>'
                    );
                    bindRemoveEvent();
                }
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Remove image functionality
    function bindRemoveEvent() {
        $('#removeImage').click(function(e) {
            e.stopPropagation();
            e.preventDefault();

            // Clear image
            $('#thumbnailPreview').css('background-image', '');
            $('#thumbnailPreview').removeClass('has-image');

            // Reset file input
            $('#thumbnail-upload').val('');

            // Remove the button
            $(this).remove();
        });
    }
});
</script>
@endpush

@push('styles')
<style>
.stats-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.language-stats {
    background: white;
    padding: 15px;
    border-radius: 6px;
    border: 1px solid #dee2e6;
}

.stat-item {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 6px;
    border: 1px solid #e9ecef;
}

.intro-location-image-upload-container {
    margin-top: 10px;
}

.image-preview-intro-location {
    width: 400px;
    height: 300px;
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

.image-preview-intro-location.has-image i,
.image-preview-intro-location.has-image span {
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
}
</style>
@endpush 