@extends('admin.layouts.sidebar')

@section('title', 'Chỉnh sửa hình ảnh')

@section('main-content')
<div class="category-form-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.image-homes.index') }}">Hình Ảnh</a></li>
            <li class="breadcrumb-item current">Chỉnh sửa</li>
        </ol>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">
                <i class="fas fa-edit icon-title"></i>
                <h5>Chỉnh sửa hình ảnh</h5>
                <small class="text-muted">(Dùng chung cho trang chủ và trang về chúng tôi)</small>
            </div>
            <div class="category-meta">
                <div class="category-created">
                    <i class="fas fa-clock"></i>
                    <span>Ngày tạo: {{ $imageHome->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
        <div class="form-body">
            
            <form action="{{ route('admin.image-homes.update', $imageHome) }}" method="POST" class="category-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="main_image" class="form-label-custom">
                        Hình ảnh chính
                    </label>
                    @if($imageHome->main_image)
                        <div class="current-image mb-3">
                            <img src="{{ $imageHome->main_image_url }}" alt="Hình ảnh chính" style="max-width: 300px; max-height: 200px;">
                        </div>
                    @endif
                    <input type="file" class="custom-input {{ $errors->has('main_image') ? 'input-error' : '' }}" 
                        id="main_image" name="main_image" accept="image/*">
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Để trống nếu không muốn thay đổi hình ảnh. Chấp nhận định dạng: JPG, PNG, GIF, WEBP. Tối đa 2MB. Kích thước khuyến nghị: 1200x600px.</span>
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
                        id="title" name="title" value="{{ old('title', $imageHome->title) }}" required maxlength="255">
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
                        id="sort_order" name="sort_order" value="{{ old('sort_order', $imageHome->sort_order) }}" min="0">
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Số nhỏ hơn sẽ hiển thị trước.</span>
                    </div>
                    @error('sort_order')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Hình ảnh phụ hiện tại</label>
                    @if($imageHome->subImages->count() > 0)
                        <div class="current-sub-images mb-3">
                            @foreach($imageHome->subImages->sortBy('sort_order') as $subImage)
                                <div class="sub-image-item">
                                    <img src="{{ $subImage->sub_image_url }}" alt="Hình ảnh phụ" style="max-width: 150px; max-height: 100px;">
                                    <div class="sub-image-controls">
                                        <input type="number" name="existing_sub_images[{{ $subImage->id }}]" 
                                            value="{{ $subImage->sort_order }}" placeholder="Thứ tự" min="0" style="width: 80px;">
                                        <label class="delete-checkbox">
                                            <input type="checkbox" name="delete_sub_images[]" value="{{ $subImage->id }}">
                                            Xóa
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">Chưa có hình ảnh phụ nào.</p>
                    @endif
                </div>

                <div class="form-group">
                    <label class="form-label-custom">Thêm hình ảnh phụ mới</label>
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
                            {{ old('is_active', $imageHome->is_active) ? 'checked' : '' }}>
                        <label for="is_active">Hiển thị hình ảnh</label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('admin.image-homes.index') }}" class="back-button">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                   
                    <div class="action-group">
                       
                        <button type="submit" class="save-button">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                    </div>
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

.current-sub-images {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
}

.sub-image-item {
    border: 1px solid #ddd;
    border-radius: 8px;
    padding: 15px;
    background: #fff;
    text-align: center;
}

.sub-image-controls {
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    align-items: center;
}

.delete-checkbox {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: 14px;
    color: #dc3545;
}

.delete-checkbox input[type="checkbox"] {
    margin: 0;
}
</style>
@endsection 