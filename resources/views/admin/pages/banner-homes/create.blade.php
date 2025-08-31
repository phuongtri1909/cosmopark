@extends('admin.layouts.sidebar')

@section('title', 'Thêm banner trang chủ mới')

@section('main-content')
<div class="category-form-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.banner-homes.index') }}">Banner Trang Chủ</a></li>
            <li class="breadcrumb-item current">Thêm mới</li>
        </ol>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">
                <i class="fas fa-plus icon-title"></i>
                <h5>Thêm banner trang chủ mới</h5>
            </div>
        </div>
        <div class="form-body"> 
            <form action="{{ route('admin.banner-homes.store') }}" method="POST" class="category-form" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="image" class="form-label-custom">
                        Hình ảnh <span class="required-mark">*</span>
                    </label>
                    <input type="file" class="custom-input {{ $errors->has('image') ? 'input-error' : '' }}" 
                        id="image" name="image" accept="image/*" required>
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Chấp nhận định dạng: JPG, PNG, GIF. Tối đa 2MB. Kích thước khuyến nghị: 1200x600px.</span>
                    </div>
                    @error('image')
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
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" 
                            {{ old('is_active', true) ? 'checked' : '' }}>
                        <label for="is_active">Hiển thị banner</label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('admin.banner-homes.index') }}" class="back-button">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="save-button">
                        <i class="fas fa-save"></i> Lưu banner
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 