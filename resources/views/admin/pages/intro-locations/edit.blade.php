@extends('admin.layouts.sidebar')

@section('title', 'Chỉnh sửa thông tin vị trí')

@section('main-content')
    <div class="category-form-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.intro-locations.index') }}">Thông tin vị trí</a></li>
                <li class="breadcrumb-item current">Chỉnh sửa</li>
            </ol>
        </div>

        <div class="form-card">
            <div class="form-header">
                <div class="form-title">
                    <i class="fas fa-edit icon-title"></i>
                    <h5>Chỉnh sửa thông tin vị trí</h5>
                </div>
                <div class="intro-location-meta">
                    <div class="intro-location-badge status {{ $introLocation->is_active ? 'active' : 'inactive' }}">
                        <i class="fas fa-{{ $introLocation->is_active ? 'check-circle' : 'times-circle' }}"></i>
                        <span>{{ $introLocation->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}</span>
                    </div>
                    <div class="intro-location-badge created">
                        <i class="fas fa-calendar"></i>
                        <span>Ngày tạo: {{ $introLocation->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="intro-location-badge order">
                        <i class="fas fa-sort"></i>
                        <span>Thứ tự: {{ $introLocation->sort_order }}</span>
                    </div>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.intro-locations.update', $introLocation) }}" method="POST" class="intro-location-form"
                    enctype="multipart/form-data" id="intro-location-form">
                    @csrf
                    @method('PUT')

                    <div class="form-tabs">
                        <!-- Ảnh và thông tin cơ bản -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label-custom">
                                        Ảnh vị trí
                                    </label>
                                    <div class="intro-location-image-upload-container">
                                        <div class="image-preview-intro-location intro-location-image-preview {{ $introLocation->image ? 'has-image' : '' }}"
                                            id="thumbnailPreview"
                                            style="background-image: url('{{ $introLocation->image ? asset('storage/' . $introLocation->image) : '' }}');">
                                            @if ($introLocation->image)
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
                                        <span>Kích thước đề xuất: 800x600px. Để trống để giữ ảnh hiện tại.</span>
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
                                        value="{{ old('sort_order', $introLocation->sort_order) }}" min="0">
                                    @error('sort_order')
                                        <div class="error-message">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check-group">
                                    <div class="custom-checkbox">
                                        <input type="checkbox" id="is_active" name="is_active" value="1"
                                            {{ old('is_active', $introLocation->is_active) ? 'checked' : '' }}>
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
                                            value="{{ old("title.$lang", $introLocation->getTranslation('title', $lang)) }}" maxlength="255">
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
                                            rows="4" maxlength="1000">{{ old("description.$lang", $introLocation->getTranslation('description', $lang)) }}</textarea>
                                        @error("description.$lang")
                                            <div class="error-message">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Thống kê -->
                        <div class="stats-section">
                            <h5 class="mb-3">Thống kê</h5>
                            
                            <div id="stats_container">
                                @if($stats && $stats->count() > 0)
                                    @foreach($stats as $index => $stat)
                                        <div class="stat-item mb-4" data-index="{{ $index }}">
                                            <div class="stat-header">
                                                <h6 class="text-muted">Thống kê #{{ $index + 1 }}</h6>
                                                <button type="button" class="btn btn-danger btn-sm remove-stat">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Nhãn / Label</label>
                                                    <input type="text" class="custom-input" name="stats[{{ $index }}][label][vi]" 
                                                           value="{{ old("stats.$index.label.vi", $stat->getTranslation('label', 'vi')) }}" placeholder="Nhãn (VD: Dân số)" maxlength="100" required>
                                                    <input type="text" class="custom-input mt-2" name="stats[{{ $index }}][label][en]" 
                                                           value="{{ old("stats.$index.label.en", $stat->getTranslation('label', 'en')) }}" placeholder="Label (e.g., Population)" maxlength="100" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Giá trị / Value</label>
                                                    <input type="text" class="custom-input" name="stats[{{ $index }}][value][vi]" 
                                                           value="{{ old("stats.$index.value.vi", $stat->getTranslation('value', 'vi')) }}" placeholder="Giá trị (VD: 3,2)" maxlength="50" required>
                                                    <input type="text" class="custom-input mt-2" name="stats[{{ $index }}][value][en]" 
                                                           value="{{ old("stats.$index.value.en", $stat->getTranslation('value', 'en')) }}" placeholder="Value (e.g., 3.2)" maxlength="50" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label-custom">Đơn vị / Unit</label>
                                                    <input type="text" class="custom-input" name="stats[{{ $index }}][unit][vi]" 
                                                           value="{{ old("stats.$index.unit.vi", $stat->getTranslation('unit', 'vi')) }}" placeholder="Đơn vị (VD: Triệu)" maxlength="20">
                                                    <input type="text" class="custom-input mt-2" name="stats[{{ $index }}][unit][en]" 
                                                           value="{{ old("stats.$index.unit.en", $stat->getTranslation('unit', 'en')) }}" placeholder="Unit (e.g., Million)" maxlength="20">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="stat-item mb-4" data-index="0">
                                        <div class="stat-header">
                                            <h6 class="text-muted">Thống kê #1</h6>
                                            <button type="button" class="btn btn-danger btn-sm remove-stat">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label class="form-label-custom">Nhãn / Label</label>
                                                <input type="text" class="custom-input" name="stats[0][label][vi]" 
                                                       placeholder="Nhãn (VD: Dân số)" maxlength="100" required>
                                                <input type="text" class="custom-input mt-2" name="stats[0][label][en]" 
                                                       placeholder="Label (e.g., Population)" maxlength="100" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label-custom">Giá trị / Value</label>
                                                <input type="text" class="custom-input" name="stats[0][value][vi]" 
                                                       placeholder="Giá trị (VD: 3,2)" maxlength="50" required>
                                                <input type="text" class="custom-input mt-2" name="stats[0][value][en]" 
                                                       placeholder="Value (e.g., 3.2)" maxlength="50" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label-custom">Đơn vị / Unit</label>
                                                <input type="text" class="custom-input" name="stats[0][unit][vi]" 
                                                       placeholder="Đơn vị (VD: Triệu)" maxlength="20">
                                                <input type="text" class="custom-input mt-2" name="stats[0][unit][en]" 
                                                       placeholder="Unit (e.g., Million)" maxlength="20">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-success btn-sm add-stat">
                                <i class="fas fa-plus"></i> Thêm thống kê
                            </button>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.intro-locations.index') }}" class="back-button">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="save-button">
                            <i class="fas fa-save"></i> Cập nhật thông tin
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
let statIndex = {{ $stats ? $stats->count() : 1 }};

$(document).ready(function() {
    // Thêm thống kê mới
    $('.add-stat').click(function() {
        const index = statIndex++;
        
        const newStat = `
            <div class="stat-item mb-4" data-index="${index}">
                <div class="stat-header">
                    <h6 class="text-muted">Thống kê #${index + 1}</h6>
                    <button type="button" class="btn btn-danger btn-sm remove-stat">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <label class="form-label-custom">Nhãn / Label</label>
                        <input type="text" class="custom-input" name="stats[${index}][label][vi]" 
                               placeholder="Nhãn (VD: Dân số)" maxlength="100" required>
                        <input type="text" class="custom-input mt-2" name="stats[${index}][label][en]" 
                               placeholder="Label (e.g., Population)" maxlength="100" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Giá trị / Value</label>
                        <input type="text" class="custom-input" name="stats[${index}][value][vi]" 
                               placeholder="Giá trị (VD: 3,2)" maxlength="50" required>
                        <input type="text" class="custom-input mt-2" name="stats[${index}][value][en]" 
                               placeholder="Value (e.g., 3.2)" maxlength="50" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label-custom">Đơn vị / Unit</label>
                        <input type="text" class="custom-input" name="stats[${index}][unit][vi]" 
                               placeholder="Đơn vị (VD: Triệu)" maxlength="20">
                        <input type="text" class="custom-input mt-2" name="stats[${index}][unit][en]" 
                               placeholder="Unit (e.g., Million)" maxlength="20">
                    </div>
                </div>
            </div>
        `;
        
        $('#stats_container').append(newStat);
    });

    // Xóa thống kê
    $(document).on('click', '.remove-stat', function() {
        const statItem = $(this).closest('.stat-item');
        
        if ($('#stats_container .stat-item').length > 1) {
            statItem.remove();
        } else {
            alert('Phải có ít nhất 1 thống kê!');
        }
    });

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

@push('styles')
<style>
.stats-section {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.stat-item {
    background: white;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    margin-bottom: 20px;
}

.stat-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
    padding-bottom: 10px;
    border-bottom: 1px solid #e9ecef;
}

.stat-header h6 {
    margin: 0;
    color: #6c757d;
}

.intro-location-badge {
    display: inline-flex;
    align-items: center;
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    margin-right: 10px;
    background-color: #f5f5f5;
}

.intro-location-badge i {
    margin-right: 5px;
}

.intro-location-badge.status.active {
    background-color: #e8f5e9;
    color: #2e7d32;
}

.intro-location-badge.status.inactive {
    background-color: #ffebee;
    color: #c62828;
}

.intro-location-badge.order {
    background-color: #e3f2fd;
    color: #1976d2;
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
    z-index: 10;
}

.intro-location-meta {
    margin-top: 10px;
}
</style>
@endpush 