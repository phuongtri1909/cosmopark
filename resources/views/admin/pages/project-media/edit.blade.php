@extends('admin.layouts.sidebar')

@section('title', 'Chỉnh sửa Media - ' . $project->getTranslation('title', 'vi'))

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Dự án</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.media.index', $project) }}">{{ $project->getTranslation('title', 'vi') }} - Media</a></li>
                <li class="breadcrumb-item current">Chỉnh sửa Media</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-edit icon-title"></i>
                    <h5>Chỉnh sửa Media - {{ $project->getTranslation('title', 'vi') }}</h5>
                </div>
                <a href="{{ route('admin.projects.media.index', $project) }}" class="action-button secondary">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>

            <div class="card-content">
                <form action="{{ route('admin.projects.media.update', [$project, $media]) }}" method="POST" enctype="multipart/form-data" class="form-edit">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-section">
                        <h6 class="section-title">
                            <i class="fas fa-cog"></i> Thông tin cơ bản
                        </h6>
                        
                        <div class="form-group">
                            <label for="type" class="form-label required">Loại Media</label>
                            <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="">Chọn loại media</option>
                                @foreach($mediaTypes as $key => $value)
                                    <option value="{{ $key }}" {{ old('type', $media->type) == $key ? 'selected' : '' }}>
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
                                   value="{{ old('title', $media->title) }}" placeholder="Nhập tiêu đề cho media">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" 
                                      placeholder="Nhập mô tả cho media">{{ old('description', $media->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sort_order" class="form-label">Thứ tự hiển thị</label>
                            <input type="number" name="sort_order" id="sort_order" class="form-control @error('sort_order') is-invalid @enderror" 
                                   value="{{ old('sort_order', $media->sort_order) }}" min="0" placeholder="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_active" id="is_active" class="form-check-input" 
                                       value="1" {{ old('is_active', $media->is_active) ? 'checked' : '' }}>
                                <label for="is_active" class="form-check-label">Hiển thị trên website</label>
                            </div>
                        </div>
                    </div>

                    <!-- Current Media Preview -->
                    <div class="form-section">
                        <h6 class="section-title">
                            <i class="fas fa-eye"></i> Media hiện tại
                        </h6>
                        
                        <div class="current-media-preview">
                            @if ($media->type === 'videos')
                                @if ($media->video_url)
                                    <div class="video-preview">
                                        <div class="preview-label">Video YouTube:</div>
                                        <div class="video-url">{{ $media->video_url }}</div>
                                        @if ($media->thumbnail_url)
                                            <div class="thumbnail-preview">
                                                <img src="{{ $media->thumbnail_url }}" alt="Video thumbnail" class="preview-image">
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="no-media">Không có video</div>
                                @endif
                            @else
                                @if ($media->file_path)
                                    <div class="file-preview">
                                        <div class="preview-label">File hiện tại:</div>
                                        <div class="file-info">
                                            <img src="{{ asset('storage/' . $media->file_path) }}" alt="{{ $media->title }}" class="preview-image">
                                            <div class="file-details">
                                                <div class="file-name">{{ basename($media->file_path) }}</div>
                                                <div class="file-size">{{ $media->file_path }}</div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="no-media">Không có file</div>
                                @endif
                            @endif
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div class="form-section" id="file-upload-section" style="display: none;">
                        <h6 class="section-title">
                            <i class="fas fa-upload"></i> Upload File mới
                        </h6>
                        
                        <div class="form-group">
                            <label for="media_file" class="form-label">File Media mới</label>
                            <input type="file" name="media_file" id="media_file" class="form-control @error('media_file') is-invalid @enderror" 
                                   accept="image/*">
                            <div class="form-hint">
                                Định dạng: JPEG, PNG, JPG, GIF, WebP. Kích thước tối đa: 2MB
                                <br><strong>Lưu ý:</strong> File cũ sẽ bị xóa khi upload file mới
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
                                   value="{{ old('video_url', $media->video_url) }}" placeholder="https://www.youtube.com/watch?v=...">
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
                            <i class="fas fa-save"></i> Cập nhật Media
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

        .current-media-preview {
            background: white;
            border-radius: 8px;
            padding: 20px;
            border: 1px solid #e9ecef;
        }

        .preview-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .video-preview, .file-preview {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .video-url {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 6px;
            font-family: monospace;
            font-size: 13px;
            color: #495057;
            word-break: break-all;
        }

        .thumbnail-preview {
            margin-top: 10px;
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .preview-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid #e9ecef;
        }

        .file-details {
            flex: 1;
        }

        .file-name {
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .file-size {
            font-size: 12px;
            color: #6c757d;
            font-family: monospace;
        }

        .no-media {
            color: #6c757d;
            font-style: italic;
            text-align: center;
            padding: 20px;
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
                    mediaFileInput.required = false; // Optional for edit
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