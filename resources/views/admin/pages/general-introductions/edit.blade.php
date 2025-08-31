@extends('admin.layouts.sidebar')

@section('title', 'Chỉnh sửa giới thiệu chung')

@section('main-content')
<div class="category-form-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.general-introductions.index') }}">Giới Thiệu Chung</a></li>
            <li class="breadcrumb-item current">Chỉnh sửa</li>
        </ol>
    </div>

    <div class="form-card">
        <div class="form-header">
            <div class="form-title">
                <i class="fas fa-edit icon-title"></i>
                <h5>Chỉnh sửa giới thiệu chung</h5>
            </div>
            <div class="category-meta">
                <div class="category-created">
                    <i class="fas fa-clock"></i>
                    <span>Cập nhật lần cuối: {{ $generalIntroduction->updated_at->format('d/m/Y H:i') }}</span>
                </div>
            </div>
        </div>
        <div class="form-body">
            
            <form action="{{ route('admin.general-introductions.update', $generalIntroduction) }}" method="POST" class="category-form">
                @csrf
                @method('PUT')
                
                <div class="row">
                    @foreach ($languages as $lang => $langName)
                        <div class="col-md-6 {{ !$loop->first ? 'mt-4 mt-md-0' : '' }}">
                            <div class="form-group">
                                <label for="title_{{ $lang }}">Tiêu đề ({{ $langName }}) <span class="required-mark">*</span></label>
                                <input type="text" name="title[{{ $lang }}]" id="title_{{ $lang }}"
                                    class="custom-input {{ $errors->has("title.$lang") ? 'input-error' : '' }}"
                                    value="{{ old("title.$lang", $generalIntroduction->getTranslation('title', $lang)) }}" required>
                                @error("title.$lang")
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="row">
                    @foreach ($languages as $lang => $langName)
                        <div class="col-md-12 {{ !$loop->first ? 'mt-4 mt-md-0' : '' }}">
                            <div class="form-group">
                                <label for="content_{{ $lang }}">Nội dung ({{ $langName }}) <span class="required-mark">*</span></label>
                                <textarea name="content[{{ $lang }}]" id="content_{{ $lang }}"
                                    class="custom-input {{ $errors->has("content.$lang") ? 'input-error' : '' }}" 
                                    rows="5" required>{{ old("content.$lang", $generalIntroduction->getTranslation('content', $lang)) }}</textarea>
                                <div class="form-hint">
                                    <i class="fas fa-info-circle"></i>
                                    <span>Tối đa 1000 ký tự.</span>
                                </div>
                                @error("content.$lang")
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="is_active" name="is_active" value="1" 
                            {{ old('is_active', $generalIntroduction->is_active) ? 'checked' : '' }}>
                        <label for="is_active">Hiển thị giới thiệu</label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <a href="{{ route('admin.general-introductions.index') }}" class="back-button">
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