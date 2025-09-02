@extends('admin.layouts.sidebar')

@section('title', 'Chỉnh sửa Tầm nhìn & Sứ mệnh')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.vision-missions.index') }}">Tầm nhìn & Sứ mệnh</a></li>
                <li class="breadcrumb-item current">Chỉnh sửa</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-edit icon-title"></i>
                    <h5>Chỉnh sửa Tầm nhìn & Sứ mệnh</h5>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.vision-missions.update', $visionMission) }}" method="POST" class="vision-mission-form">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="type" class="form-label">Loại <span class="required">*</span></label>
                            <select name="type" id="type" class="form-control" required>
                                <option value="">Chọn loại</option>
                                <option value="vision" {{ old('type', $visionMission->type) === 'vision' ? 'selected' : '' }}>Tầm nhìn</option>
                                <option value="mission" {{ old('type', $visionMission->type) === 'mission' ? 'selected' : '' }}>Sứ mệnh</option>
                            </select>
                            @error('type')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="sort_order" class="form-label">Thứ tự</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control"
                                value="{{ old('sort_order', $visionMission->sort_order) }}" min="0">
                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>Số càng nhỏ càng hiển thị trước.</span>
                            </div>
                            @error('sort_order')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tiêu đề <span class="required">*</span></label>
                        <div class="language-fields">
                            <div class="lang-field">
                                <label class="lang-label">Tiếng Việt</label>
                                <input type="text" name="title[vi]" class="form-control"
                                    value="{{ old('title.vi', $visionMission->getTranslation('title', 'vi')) }}" 
                                    placeholder="Nhập tiêu đề tiếng Việt" required>
                                @error('title.vi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="lang-field">
                                <label class="lang-label">English</label>
                                <input type="text" name="title[en]" class="form-control"
                                    value="{{ old('title.en', $visionMission->getTranslation('title', 'en')) }}" 
                                    placeholder="Enter English title" required>
                                @error('title.en')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mô tả <span class="required">*</span></label>
                        <div class="language-fields">
                            <div class="lang-field">
                                <label class="lang-label">Tiếng Việt</label>
                                <textarea name="description[vi]" class="form-control" rows="4"
                                    placeholder="Nhập mô tả tiếng Việt" required>{{ old('description.vi', $visionMission->getTranslation('description', 'vi')) }}</textarea>
                                @error('description.vi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="lang-field">
                                <label class="lang-label">English</label>
                                <textarea name="description[en]" class="form-control" rows="4"
                                    placeholder="Enter English description" required>{{ old('description.en', $visionMission->getTranslation('description', 'en')) }}</textarea>
                                @error('description.en')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                {{ old('is_active', $visionMission->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Hiển thị</label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.vision-missions.index') }}" class="back-button">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                        <button type="submit" class="save-button">
                            <i class="fas fa-save"></i> Cập nhật
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .language-fields {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .lang-field {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background: #f8f9fa;
        }

        .lang-label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            font-size: 14px;
        }
    </style>
@endpush 