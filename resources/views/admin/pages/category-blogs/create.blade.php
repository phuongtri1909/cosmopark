@extends('admin.layouts.sidebar')

@section('title', 'Thêm danh mục bài viết')

@section('main-content')
    <div class="category-form-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.category-blogs.index') }}">Danh mục bài viết</a></li>
                <li class="breadcrumb-item current">Thêm mới</li>
            </ol>
        </div>

        <div class="form-card">
            <div class="form-header">
                <div class="form-title">
                    <i class="fas fa-folder-plus icon-title"></i>
                    <h5>Thêm danh mục bài viết mới</h5>
                </div>
            </div>

            <div class="form-body">
                @include('components.alert', ['alertType' => 'alert'])

                <form action="{{ route('admin.category-blogs.store') }}" method="POST" class="category-form">
                    @csrf

                    <div class="row">
                        @foreach ($languages as $lang => $langName)
                            <div class="col-md-6 {{ !$loop->first ? 'mt-4 mt-md-0' : '' }}">
                                <div class="form-group">
                                    <label for="name_{{ $lang }}">Tên danh mục ({{ $langName }}) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="name[{{ $lang }}]" id="name_{{ $lang }}"
                                        class="form-control {{ $errors->has("name.$lang") ? 'is-invalid' : '' }}"
                                        value="{{ old("name.$lang", isset($categoryBlog) ? $categoryBlog->getTranslation('name', $lang) : '') }}">
                                    @error("name.$lang")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group mt-2">
                                    <label for="description_{{ $lang }}">Mô tả ({{ $langName }})</label>
                                    <textarea name="description[{{ $lang }}]" id="description_{{ $lang }}"
                                        class="form-control {{ $errors->has("description.$lang") ? 'is-invalid' : '' }}" rows="3">{{ old("description.$lang", isset($categoryBlog) ? $categoryBlog->getTranslation('description', $lang) : '') }}</textarea>
                                    @error("description.$lang")
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="slug" class="form-label-custom">
                            Slug <span class="form-hint">(Để trống để tự động tạo)</span>
                        </label>
                        <input type="text" class="custom-input {{ $errors->has('slug') ? 'input-error' : '' }}"
                            id="slug" name="slug" value="{{ old('slug') }}">
                        @error('slug')
                            <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a href="{{ route('admin.category-blogs.index') }}" class="back-button">
                            <i class="fas fa-arrow-left"></i> Quay lại
                        </a>
                        <button type="submit" class="save-button">
                            <i class="fas fa-save"></i> Lưu danh mục
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Auto-generate slug from name
        const nameViInput = document.getElementById('name_vi');
    const slugInput = document.getElementById('slug');
    const originalSlug = "{{ isset($categoryBlog) ? $categoryBlog->slug : '' }}";

    if (nameViInput && slugInput) {
        nameViInput.addEventListener('keyup', function() {
            // Chỉ tự động tạo slug nếu slug chưa thay đổi thủ công
            if (!slugInput.value || slugInput.value === originalSlug) {
                slugInput.value = createSlug(this.value);
            }
        });
    }

    function createSlug(text) {
        return text
            .toString()
            .normalize('NFD')
            .replace(/[\u0300-\u036f]/g, '')
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-');
    }
    </script>
@endpush
