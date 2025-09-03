@extends('admin.layouts.sidebar')

@section('title', 'Quản lý Media - ' . $project->getTranslation('title', 'vi'))

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.index') }}">Dự án</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.projects.edit', $project) }}">{{ $project->getTranslation('title', 'vi') }}</a></li>
                <li class="breadcrumb-item current">Media</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-images icon-title"></i>
                    <h5>Quản lý Media - {{ $project->getTranslation('title', 'vi') }}</h5>
                </div>
                <a href="{{ route('admin.projects.media.create', $project) }}" class="action-button">
                    <i class="fas fa-plus"></i> Thêm Media
                </a>
            </div>

            <div class="card-content">
                @if ($media->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <h4>Chưa có media nào</h4>
                        <p>Bắt đầu bằng cách thêm media đầu tiên cho dự án này.</p>
                        <a href="{{ route('admin.projects.media.create', $project) }}" class="action-button">
                            <i class="fas fa-plus"></i> Thêm Media
                        </a>
                    </div>
                @else
                    <div class="media-stats mb-4">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-image"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number">{{ $project->images()->count() }}</div>
                                        <div class="stat-label">Hình ảnh</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-drafting-compass"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number">{{ $project->plans()->count() }}</div>
                                        <div class="stat-label">Kế hoạch</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-video"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number">{{ $project->videos()->count() }}</div>
                                        <div class="stat-label">Video</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="stat-card">
                                    <div class="stat-icon">
                                        <i class="fas fa-street-view"></i>
                                    </div>
                                    <div class="stat-content">
                                        <div class="stat-number">{{ $project->streetViews()->count() }}</div>
                                        <div class="stat-label">Street View</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="column-small">STT</th>
                                    <th class="column-small">Preview</th>
                                    <th class="column-medium">Thông tin</th>
                                    <th class="column-small">Loại</th>
                                    <th class="column-small">Thứ tự</th>
                                    <th class="column-small text-center">Trạng thái</th>
                                    <th class="column-small text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-media">
                                @foreach ($media as $index => $item)
                                    <tr data-id="{{ $item->id }}">
                                        <td class="text-center">
                                            {{ ($media->currentPage() - 1) * $media->perPage() + $index + 1 }}
                                        </td>
                                        <td class="text-center">
                                            @if ($item->type === 'videos')
                                                @if ($item->thumbnail_url)
                                                    <img src="{{ $item->thumbnail_url }}" 
                                                         alt="{{ $item->title }}" 
                                                         class="media-thumbnail" width="50" height="50">
                                                @else
                                                    <div class="media-placeholder">
                                                        <i class="fas fa-video"></i>
                                                    </div>
                                                @endif
                                            @else
                                                @if ($item->file_path)
                                                    <img src="{{ asset('storage/' . $item->file_path) }}" 
                                                         alt="{{ $item->title }}" 
                                                         class="media-thumbnail" width="50" height="50">
                                                @else
                                                    <div class="media-placeholder">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            <div class="media-info">
                                                <div class="media-title">{{ $item->title ?: 'Không có tiêu đề' }}</div>
                                                @if ($item->description)
                                                    <div class="media-description">{{ Str::limit($item->description, 60) }}</div>
                                                @endif
                                                @if ($item->type === 'videos' && $item->video_url)
                                                    <div class="media-url">
                                                        <small class="text-muted">{{ Str::limit($item->video_url, 40) }}</small>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="type-badge type-{{ $item->type }}">
                                                @switch($item->type)
                                                    @case('images')
                                                        <i class="fas fa-image"></i> Hình ảnh
                                                        @break
                                                    @case('plans')
                                                        <i class="fas fa-drafting-compass"></i> Kế hoạch
                                                        @break
                                                    @case('videos')
                                                        <i class="fas fa-video"></i> Video
                                                        @break
                                                    @case('street-views')
                                                        <i class="fas fa-street-view"></i> Street View
                                                        @break
                                                @endswitch
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <span class="order-badge">{{ $item->sort_order }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge {{ $item->is_active ? 'status-active' : 'status-inactive' }}">
                                                {{ $item->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons-wrapper">
                                                <a href="{{ route('admin.projects.media.edit', [$project, $item]) }}"
                                                    class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @include('components.delete-form', [
                                                    'id' => $item->id,
                                                    'route' => route('admin.projects.media.destroy', [$project, $item]),
                                                    'message' => "Bạn có chắc chắn muốn xóa media này?",
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
                            Hiển thị {{ $media->firstItem() ?? 0 }} đến {{ $media->lastItem() ?? 0 }} của
                            {{ $media->total() }} media
                        </div>
                        <div class="pagination-controls">
                            {{ $media->links('components.paginate') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .media-stats {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
        }

        .stat-card {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-color-4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgb(0, 0, 0);
            font-size: 20px;
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: var(--primary-color);
        }

        .stat-label {
            font-size: 14px;
            color: #666;
            margin-top: 2px;
        }

        .media-thumbnail {
            border-radius: 8px;
            object-fit: cover;
        }

        .media-placeholder {
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

        .media-info {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .media-title {
            font-weight: 600;
            color: #333;
        }

        .media-description {
            font-size: 13px;
            color: #666;
        }

        .media-url {
            font-size: 11px;
        }

        .type-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .type-images {
            background: #e8f5e8;
            color: #2e7d32;
        }

        .type-plans {
            background: #fff3e0;
            color: #f57c00;
        }

        .type-videos {
            background: #fce4ec;
            color: #c2185b;
        }

        .type-street-views {
            background: #e3f2fd;
            color: #1976d2;
        }

        .order-badge {
            display: inline-block;
            background: #f8f9fa;
            color: #495057;
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 600;
        }

        #sortable-media tr {
            cursor: move;
        }

        #sortable-media tr:hover {
            background-color: #f8f9fa;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tbody = document.getElementById('sortable-media');
            if (tbody) {
                new Sortable(tbody, {
                    animation: 150,
                    onEnd: function(evt) {
                        const rows = Array.from(tbody.querySelectorAll('tr'));
                        const mediaOrder = rows.map(row => row.dataset.id);
                        
                        // Update order via API
                        fetch('{{ route("admin.projects.media.order", $project) }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ media_order: mediaOrder })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Update order numbers
                                rows.forEach((row, index) => {
                                    const orderCell = row.querySelector('.order-badge');
                                    if (orderCell) {
                                        orderCell.textContent = index;
                                    }
                                });
                            }
                        })
                        .catch(error => console.error('Error updating order:', error));
                    }
                });
            }
        });
    </script>
@endpush 