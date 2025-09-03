@extends('admin.layouts.sidebar')

@section('title', 'Quản lý Dự án')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item current">Dự án</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-project-diagram icon-title"></i>
                    <h5>Danh sách Dự án</h5>
                </div>
                <a href="{{ route('admin.projects.create') }}" class="action-button">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>

            <div class="card-content">
                @if ($projects->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                        <h4>Chưa có dự án nào</h4>
                        <p>Bắt đầu bằng cách thêm dự án đầu tiên.</p>
                        <a href="{{ route('admin.projects.create') }}" class="action-button">
                            <i class="fas fa-plus"></i> Thêm mới
                        </a>
                    </div>
                @else
                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="column-small">STT</th>
                                    <th class="column-small">Ảnh</th>
                                    <th class="column-medium">Tiêu đề</th>
                                    <th class="column-medium">Mô tả</th>
                                    <th class="column-small">Số liệu</th>
                                    <th class="column-small">Slug</th>
                                    <th class="column-small text-center">Trạng thái</th>
                                    <th class="column-small text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($projects as $index => $project)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($projects->currentPage() - 1) * $projects->perPage() + $index + 1 }}
                                        </td>
                                        <td class="text-center">
                                            @if ($project->hero_image)
                                                <img src="{{ asset('storage/' . $project->hero_image) }}" 
                                                     alt="{{ $project->getTranslation('title', 'vi') }}" 
                                                     class="project-image" width="50" height="50">
                                            @else
                                                <div class="project-image-placeholder">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ $project->getTranslation('title', 'vi') }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ $project->getTranslation('title', 'en') }}</span>
                                                </div>
                                                @if($project->getTranslation('subtitle', 'vi'))
                                                <div class="lang-item">
                                                    <span class="lang-label">Sub:</span>
                                                    <span class="lang-text">{{ $project->getTranslation('subtitle', 'vi') }}</span>
                                                </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ Str::limit($project->getTranslation('description', 'vi'), 60) }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ Str::limit($project->getTranslation('description', 'en'), 60) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="number-badge">{{ $project->number }} {{ $project->unit }}</span>
                                        </td>
                                        <td>
                                            <code class="slug-text">{{ $project->slug }}</code>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge {{ $project->is_active ? 'status-active' : 'status-inactive' }}">
                                                {{ $project->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons-wrapper">
                                                <a href="{{ route('admin.projects.media.index', $project) }}"
                                                    class="action-icon media-icon text-decoration-none" title="Quản lý Media">
                                                    <i class="fas fa-images"></i>
                                                </a>
                                                <a href="{{ route('admin.projects.edit', $project) }}"
                                                    class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @include('components.delete-form', [
                                                    'id' => $project->id,
                                                    'route' => route('admin.projects.destroy', $project),
                                                    'message' => "Bạn có chắc chắn muốn xóa dự án '{$project->getTranslation('title', 'vi')}'?",
                                                ])
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination-wrapper">
                        <div class="pagination-info">
                            Hiển thị {{ $projects->firstItem() ?? 0 }} đến {{ $projects->lastItem() ?? 0 }} của
                            {{ $projects->total() }} dự án
                        </div>
                        <div class="pagination-controls">
                            {{ $projects->links('components.paginate') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .project-image {
            border-radius: 8px;
            object-fit: cover;
        }

        .project-image-placeholder {
            width: 50px;
            height: 50px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 18px;
        }

        .number-badge {
            display: inline-block;
            background: #e8f5e8;
            color: #2e7d32;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        .slug-text {
            background: #f8f9fa;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 11px;
            color: #495057;
        }

        .multi-lang-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .lang-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .lang-label {
            font-weight: 600;
            color: #666;
            font-size: 12px;
            min-width: 25px;
        }

        .lang-text {
            color: #333;
            font-size: 13px;
        }

        .media-icon {
            color: #17a2b8;
        }

        .media-icon:hover {
            color: #138496;
        }
    </style>
@endpush 