@extends('admin.layouts.sidebar')

@section('title', 'Thêm Gallery mới')

@section('main-content')
<div class="category-form-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.galleries.index') }}">Gallery</a></li>
            <li class="breadcrumb-item current">Thêm mới</li>
        </ol>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">
                <i class="fas fa-plus icon-title"></i>
                <h5>Thêm Gallery mới</h5>
            </div>
        </div>
        <div class="form-body"> 
            <form action="{{ route('admin.galleries.store') }}" method="POST" class="category-form" enctype="multipart/form-data">
                @csrf
                
                <div class="form-group">
                    <label for="project_id" class="form-label-custom">
                        Dự án <span class="required-mark">*</span>
                    </label>
                    <select class="custom-input {{ $errors->has('project_id') ? 'input-error' : '' }}" 
                        id="project_id" name="project_id" required>
                        <option value="">-- Chọn dự án --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project['id'] }}" {{ old('project_id') == $project['id'] ? 'selected' : '' }}>
                                {{ $project['title'] }}
                            </option>
                        @endforeach
                    </select>
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Chọn dự án mà gallery này thuộc về.</span>
                    </div>
                    @error('project_id')
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
                        <span>Tiêu đề hiển thị cho Gallery.</span>
                    </div>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image_1" class="form-label-custom">
                        Hình ảnh chính <span class="required-mark">*</span>
                    </label>
                    <input type="file" class="custom-input {{ $errors->has('image_1') ? 'input-error' : '' }}" 
                        id="image_1" name="image_1" accept="image/*" required>
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Chấp nhận định dạng: JPG, PNG, GIF, WEBP. Tối đa 2MB. Kích thước khuyến nghị: 1200x600px.</span>
                    </div>
                    @error('image_1')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image_2" class="form-label-custom">Hình ảnh 2</label>
                    <input type="file" class="custom-input {{ $errors->has('image_2') ? 'input-error' : '' }}" 
                        id="image_2" name="image_2" accept="image/*">
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Hình ảnh phụ thứ 2.</span>
                    </div>
                    @error('image_2')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image_3" class="form-label-custom">Hình ảnh 3</label>
                    <input type="file" class="custom-input {{ $errors->has('image_3') ? 'input-error' : '' }}" 
                        id="image_3" name="image_3" accept="image/*">
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Hình ảnh phụ thứ 3.</span>
                    </div>
                    @error('image_3')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image_4" class="form-label-custom">Hình ảnh 4</label>
                    <input type="file" class="custom-input {{ $errors->has('image_4') ? 'input-error' : '' }}" 
                        id="image_4" name="image_4" accept="image/*">
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Hình ảnh phụ thứ 4.</span>
                    </div>
                    @error('image_4')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image_5" class="form-label-custom">Hình ảnh 5</label>
                    <input type="file" class="custom-input {{ $errors->has('image_5') ? 'input-error' : '' }}" 
                        id="image_5" name="image_5" accept="image/*">
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Hình ảnh phụ thứ 5.</span>
                    </div>
                    @error('image_5')
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
                        <label for="is_active">Hiển thị Gallery</label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('admin.galleries.index') }}" class="back-button">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="save-button">
                        <i class="fas fa-save"></i> Lưu Gallery
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection