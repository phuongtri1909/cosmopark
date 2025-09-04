@extends('admin.layouts.sidebar')

@section('title', 'Chỉnh sửa Gallery')

@section('main-content')
<div class="category-form-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.galleries.index') }}">Gallery</a></li>
            <li class="breadcrumb-item current">Chỉnh sửa</li>
        </ol>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">
                <i class="fas fa-edit icon-title"></i>
                <h5>Chỉnh sửa Gallery</h5>
            </div>
            <div class="category-meta">
                <div class="category-created">
                    <i class="fas fa-clock"></i>
                    <span>Ngày tạo: {{ $gallery->created_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
        <div class="form-body">
            
            <form action="{{ route('admin.galleries.update', $gallery) }}" method="POST" class="category-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label for="project_id" class="form-label-custom">
                        Dự án <span class="required-mark">*</span>
                    </label>
                    <select class="custom-input {{ $errors->has('project_id') ? 'input-error' : '' }}" 
                        id="project_id" name="project_id" required>
                        <option value="">-- Chọn dự án --</option>
                        @foreach($projects as $project)
                            <option value="{{ $project['id'] }}" {{ old('project_id', $gallery->project_id) == $project['id'] ? 'selected' : '' }}>
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
                        id="title" name="title" value="{{ old('title', $gallery->title) }}" required maxlength="255">
                    <div class="form-hint">
                        <i class="fas fa-info-circle"></i>
                        <span>Tiêu đề hiển thị cho Gallery.</span>
                    </div>
                    @error('title')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                @for($i = 1; $i <= 5; $i++)
                    <div class="form-group">
                        <label for="image_{{ $i }}" class="form-label-custom">
                            Hình ảnh {{ $i }}{{ $i == 1 ? ' (Chính)' : '' }}
                        </label>
                        @if($gallery->{"image_{$i}"})
                            <div class="current-image mb-3">
                                <img src="{{ asset('storage/' . $gallery->{"image_{$i}"}) }}" alt="Hình ảnh {{ $i }}" style="max-width: 200px; max-height: 150px; border-radius: 8px;">
                            </div>
                        @endif
                        <input type="file" class="custom-input {{ $errors->has("image_{$i}") ? 'input-error' : '' }}" 
                            id="image_{{ $i }}" name="image_{{ $i }}" accept="image/*">
                        <div class="form-hint">
                            <i class="fas fa-info-circle"></i>
                            <span>{{ $i == 1 ? 'Để trống nếu không muốn thay đổi hình ảnh chính.' : 'Để trống nếu không muốn thay đổi hình ảnh phụ.' }}</span>
                        </div>
                        @error("image_{$i}")
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>
                @endfor
                
                <div class="form-group">
                    <label for="sort_order" class="form-label-custom">Thứ tự hiển thị</label>
                    <input type="number" class="custom-input {{ $errors->has('sort_order') ? 'input-error' : '' }}" 
                        id="sort_order" name="sort_order" value="{{ old('sort_order', $gallery->sort_order) }}" min="0">
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
                            {{ old('is_active', $gallery->is_active) ? 'checked' : '' }}>
                        <label for="is_active">Hiển thị Gallery</label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('admin.galleries.index') }}" class="back-button">
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
@endsection