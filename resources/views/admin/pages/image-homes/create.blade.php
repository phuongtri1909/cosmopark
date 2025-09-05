@extends('admin.layouts.sidebar')

@section('title', 'Thêm hình ảnh mới')

@section('main-content')
<div class="category-form-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.image-homes.index') }}">Hình Ảnh</a></li>
            <li class="breadcrumb-item current">Thêm mới</li>
        </ol>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">
                <i class="fas fa-plus icon-title"></i>
                <h5>Thêm hình ảnh mới</h5>
                
                <small class="text-muted">(Dùng chung cho trang chủ và trang về chúng tôi)</small>
            </div>
        </div>
        <div class="form-body"> 
            <form action="{{ route('admin.image-homes.store') }}" method="POST" class="category-form" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="main_image" class="form-label-custom">
                        Hình ảnh chính <span class="required-mark">*</span>
                    </label>
                    <input type="file" class="custom-input {{ $errors->has('main_image') ? 'input-error' : '' }}" 
                        id="main_image" name="main_image" accept="image/*" required>
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Chấp nhận định dạng: JPG, PNG, GIF, WEBP. Tối đa 2MB. Kích thước khuyến nghị: 1200x600px.</span>
                    </div>
                    @error('main_image')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="title" class="form-label-custom">
                        Tiêu đề <span class="required-mark">*</span>
                    </label>
                    <input type="text" class="custom-input {{ $errors->has('title') ? 'input-error' : '' }}" 
                        id="title" name="title" value="{{ old('title') }}" required maxlength="255">
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Tiêu đề hiển thị trên hình ảnh chính.</span>
                    </div>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="sort_order" class="form-label-custom">Thứ tự hiển thị</label>
                    <input type="number" class="custom-input {{ $errors->has('sort_order') ? 'input-error' : '' }}" 
                        id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Số nhỏ hơn sẽ hiển thị trước.</span>
                    </div>
                    @error('sort_order')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Hình ảnh phụ</label>
                    <div class="sub-images-container">
                        <div class="sub-image-row">
                            <div class="sub-image-input">
                                <input type="file" class="custom-input" name="sub_images[]" accept="image/*">
                                <input type="number" class="custom-input mt-2" name="sub_sort_orders[]" placeholder="Thứ tự" value="0" min="0">
                            </div>
                            <div class="sub-image-input">
                                <input type="file" class="custom-input" name="sub_images[]" accept="image/*">
                                <input type="number" class="custom-input mt-2" name="sub_sort_orders[]" placeholder="Thứ tự" value="1" min="0">
                            </div>
                        </div>
                        <div class="sub-image-row">
                            <div class="sub-image-input">
                                <input type="file" class="custom-input" name="sub_images[]" accept="image/*">
                                <input type="number" class="custom-input mt-2" name="sub_sort_orders[]" placeholder="Thứ tự" value="2" min="0">
                            </div>
                            <div class="sub-image-input">
                                <input type="file" class="custom-input" name="sub_images[]" accept="image/*">
                                <input type="number" class="custom-input mt-2" name="sub_sort_orders[]" placeholder="Thứ tự" value="3" min="0">
                            </div>
                        </div>
                    </div>
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Chấp nhận định dạng: JPG, PNG, GIF, WEBP. Tối đa 2MB mỗi ảnh. Kích thước khuyến nghị: 800x600px.</span>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" 
                            {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active">Hiển thị hình ảnh</label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('admin.image-homes.index') }}" class="back-button">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="save-button">
                        <i class="fas fa-save"></i> Lưu hình ảnh
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.sub-images-container {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 20px;
    background: #f8f9fa;
}

.sub-image-row {
    display: flex;
    gap: 20px;
    margin-bottom: 20px;
}

.sub-image-row:last-child {
    margin-bottom: 0;
}

.sub-image-input {
    flex: 1;
}

.sub-image-input input[type="file"] {
    margin-bottom: 10px;
}

.sub-image-input input[type="number"] {
    width: 100%;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}
</style>
@endsection 