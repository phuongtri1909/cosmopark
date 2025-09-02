@extends('admin.layouts.sidebar')

@section('title', 'Chỉnh sửa Ngành công nghiệp')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.industries.index') }}">Ngành công nghiệp</a></li>
                <li class="breadcrumb-item current">Chỉnh sửa</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-edit icon-title"></i>
                    <h5>Chỉnh sửa Ngành công nghiệp</h5>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.industries.update', $industry) }}" method="POST" class="industry-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="sort_order" class="form-label">Thứ tự</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control"
                                value="{{ old('sort_order', $industry->sort_order) }}" min="0">
                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>Số càng nhỏ càng hiển thị trước.</span>
                            </div>
                            @error('sort_order')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group col-md-6">
                            <label for="icon" class="form-label">Icon</label>
                            @if ($industry->icon)
                                <div class="current-icon mb-2">
                                    <img src="{{ asset('storage/' . $industry->icon) }}" 
                                         alt="Current icon" width="40" height="40" class="rounded">
                                    <span class="ms-2 text-muted">Icon hiện tại</span>
                                </div>
                            @endif
                            <input type="file" name="icon" id="icon" class="form-control" accept="image/*">
                            <div class="form-hint">
                                <i class="fas fa-info-circle"></i>
                                <span>Hỗ trợ: jpeg, png, jpg, gif, svg. Tối đa 2MB. Để trống để giữ icon hiện tại.</span>
                            </div>
                            @error('icon')
                                <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tên ngành <span class="required">*</span></label>
                        <div class="language-fields">
                            <div class="lang-field">
                                <label class="lang-label">Tiếng Việt</label>
                                <input type="text" name="name[vi]" class="form-control"
                                    value="{{ old('name.vi', $industry->getTranslation('name', 'vi')) }}" 
                                    placeholder="Nhập tên ngành tiếng Việt" required>
                                @error('name.vi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="lang-field">
                                <label class="lang-label">English</label>
                                <input type="text" name="name[en]" class="form-control"
                                    value="{{ old('name.en', $industry->getTranslation('name', 'en')) }}" 
                                    placeholder="Enter English industry name" required>
                                @error('name.en')
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
                                    placeholder="Nhập mô tả tiếng Việt" required>{{ old('description.vi', $industry->getTranslation('description', 'vi')) }}</textarea>
                                @error('description.vi')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="lang-field">
                                <label class="lang-label">English</label>
                                <textarea name="description[en]" class="form-control" rows="4"
                                    placeholder="Enter English description" required>{{ old('description.en', $industry->getTranslation('description', 'en')) }}</textarea>
                                @error('description.en')
                                    <div class="error-message">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
                                {{ old('is_active', $industry->is_active) ? 'checked' : '' }}>
                            <label for="is_active" class="form-check-label">Hiển thị</label>
                        </div>
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.industries.index') }}" class="back-button">
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

        .form-hint {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 5px;
            font-size: 12px;
            color: #666;
        }

        .form-hint i {
            color: #007bff;
        }

        .current-icon {
            display: flex;
            align-items: center;
        }

        .current-icon img {
            border: 1px solid #ddd;
        }
    </style>
@endpush 