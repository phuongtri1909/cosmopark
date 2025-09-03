@extends('admin.layouts.sidebar')

@section('title', 'Thêm Media - ' . $project->getTranslation('title', 'vi'))

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Dự án</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.media.index', $project) }}">{{ $project->getTranslation('title', 'vi') }} - Media</a></li>
                <li class="breadcrumb-item current">Thêm Media</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-plus icon-title"></i>
                    <h5>Thêm Media mới cho {{ $project->getTranslation('title', 'vi') }}</h5>
                </div>
                <a href="{{ route('admin.projects.media.index', $project) }}" class="action-button secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <div class="card-content">
                <form action="{{ route('admin.projects.media.store', $project) }}" method="POST" enctype="multipart/form-data" class="form-create">
                    @csrf
                    
                    <div class="form-section">
                        <h6 class="section-title">
                            <i class="fas fa-cog"></i> Thông tin cơ bản
                        </h6>
                        
                        <div class="form-group">
                            <label for="type" class="form-label required">Loại Media</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Chọn loại media</option>
                                @foreach($mediaTypes as $key => $value)
                                    <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="title" class="form-label">Tiêu đề</label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}" placeholder="Nhập tiêu đề cho media">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Nhập mô tả cho media">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sort_order" class="form-label">Thứ tự hiển thị</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                                   value="{{ old('sort_order', 0) }}" min="0" placeholder="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" 
                                       value="1" {{ old('is_active') ? 'checked' : '' }}>
                                <label for="is_active" class="form-check-label">Hiển thị trên website</label>
                            </div>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="form-section" id="file-upload-section" style="display: none;">
                        <h6 class="section-title">
                            <i class="fas fa-upload"></i> Upload File
                        </h6>
                        
                        <div class="form-group">
                            <label for="media_file" class="form-label required">File Media</label>
                            <input type="file" name="media_file" id="media_file" class="form-control @error('media_file') is-invalid @enderror" 
                                   accept="image/*">
                            <div class="form-hint">
                                Định dạng: JPEG, PNG, JPG, GIF, WebP. Kích thước tối đa: 2MB
                            </div>
                            @error('media_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- YouTube URL Section -->
                    <div class="form-section" id="youtube-section" style="display: none;">
                        <h6 class="section-title">
                            <i class="fab fa-youtube"></i> YouTube Video
                        </h6>
                        
                        <div class="form-group">
                            <label for="video_url" class="form-label required">URL Video YouTube</label>
                            <input type="url" name="video_url" id="video_url" class="form-control @error('video_url') is-invalid @enderror" 
                                   value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=...">
                            <div class="form-hint">
                                Nhập URL video YouTube (ví dụ: https://www.youtube.com/watch?v=VIDEO_ID)
                            </div>
                            @error('video_url')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="action-button">
                            <i class="fas fa-save"></i> Lưu Media
                        </button>
                        <a href="{{ route('admin.projects.media.index', $project) }}" class="action-button secondary">
                            <i class="fas fa-times"></i> Hủy
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .form-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-title {
            color: var(--primary-color-4);
            margin-bottom: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        .form-label.required::after {
            content: " *";
            color: #dc3545;
        }

        .form-control {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary-color-4);
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }

        .form-hint {
            font-size: 12px;
            color: #6c757d;
            margin-top: 5px;
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-check-input {
            margin: 0;
        }

        .form-check-label {
            margin: 0;
            font-weight: 500;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-start;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .action-button.secondary {
            background: #6c757d;
        }

        .action-button.secondary:hover {
            background: #5a6268;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const fileSection = document.getElementById('file-upload-section');
            const youtubeSection = document.getElementById('youtube-section');
            const mediaFileInput = document.getElementById('media_file');
            const videoUrlInput = document.getElementById('video_url');

            function toggleSections() {
                const selectedType = typeSelect.value;
                
                // Hide both sections first
                fileSection.style.display = 'none';
                youtubeSection.style.display = 'none';
                
                // Show appropriate section based on type
                if (['images', 'plans', 'street-views'].includes(selectedType)) {
                    fileSection.style.display = 'block';
                    mediaFileInput.required = true;
                    videoUrlInput.required = false;
                } else if (selectedType === 'videos') {
                    youtubeSection.style.display = 'block';
                    videoUrlInput.required = true;
                    mediaFileInput.required = false;
                } else {
                    mediaFileInput.required = false;
                    videoUrlInput.required = false;
                }
            }

            // Initial toggle
            toggleSections();
            
            // Toggle on change
            typeSelect.addEventListener('change', toggleSections);
        });
    </script>
@endpush 