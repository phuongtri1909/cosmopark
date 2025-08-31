@extends('admin.layouts.sidebar')

@section('title', 'Thêm tính năng giới thiệu mới')

@section('main-content')
<div class="category-form-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.intro-features.index') }}">Tính Năng Giới Thiệu</a></li>
            <li class="breadcrumb-item current">Thêm mới</li>
        </ol>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">
                <i class="fas fa-plus icon-title"></i>
                <h5>Thêm tính năng giới thiệu mới</h5>
            </div>
        </div>
        <div class="form-body">
            
            <form action="{{ route('admin.intro-features.store') }}" method="POST" class="category-form">
                @csrf
                
                <div class="row">
                    @foreach ($languages as $lang => $langName)
                        <div class="col-md-6 {{ !$loop->first ? 'mt-4 mt-md-0' : '' }}">
                            <div class="form-group">
                                <label for="name_{{ $lang }}">Tên tính năng ({{ $langName }}) <span class="required-mark">*</span></label>
                                <input type="text" name="name[{{ $lang }}]" id="name_{{ $lang }}"
                                    class="custom-input {{ $errors->has("name.$lang") ? 'input-error' : '' }}"
                                    value="{{ old("name.$lang") }}" required>
                                @error("name.$lang")
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="row">
                    @foreach ($languages as $lang => $langName)
                        <div class="col-md-6 {{ !$loop->first ? 'mt-4 mt-md-0' : '' }}">
                            <div class="form-group">
                                <label for="value_{{ $lang }}">Giá trị ({{ $langName }}) <span class="required-mark">*</span></label>
                                <input type="text" name="value[{{ $lang }}]" id="value_{{ $lang }}"
                                    class="custom-input {{ $errors->has("value.$lang") ? 'input-error' : '' }}"
                                    value="{{ old("value.$lang") }}" required>
                                <div class="form-hint">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Ví dụ: 322, >120, >1000</span>
                                </div>
                                @error("value.$lang")
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="row">
                    @foreach ($languages as $lang => $langName)
                        <div class="col-md-6 {{ !$loop->first ? 'mt-4 mt-md-0' : '' }}">
                            <div class="form-group">
                                <label for="unit_{{ $lang }}">Đơn vị ({{ $langName }}) <span class="required-mark">*</span></label>
                                <input type="text" name="unit[{{ $lang }}]" id="unit_{{ $lang }}"
                                    class="custom-input {{ $errors->has("unit.$lang") ? 'input-error' : '' }}"
                                    value="{{ old("unit.$lang") }}" required>
                                <div class="form-hint">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Ví dụ: ha, km, m²</span>
                                </div>
                                @error("unit.$lang")
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach
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
                        <label for="is_active">Hiển thị tính năng</label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('admin.intro-features.index') }}" class="back-button">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                    <button type="submit" class="save-button">
                        <i class="fas fa-save"></i> Tạo tính năng
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 