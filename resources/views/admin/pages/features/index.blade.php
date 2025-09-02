@extends('admin.layouts.sidebar')

@section('title', 'Quản lý Features')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item current">Features</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-cog icon-title"></i>
                    <h5>Danh sách Features</h5>
                </div>
                <a href="{{ route('admin.features.create') }}" class="action-button">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>

            <div class="card-content">
                @if ($features->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-cog"></i>
                        </div>
                        <h4>Chưa có Feature nào</h4>
                        <p>Bắt đầu bằng cách thêm Feature đầu tiên.</p>
                        <a href="{{ route('admin.features.create') }}" class="action-button">
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
                                    <th class="column-small">Thứ tự</th>
                                    <th class="column-small text-center">Trạng thái</th>
                                    <th class="column-small text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($features as $index => $feature)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($features->currentPage() - 1) * $features->perPage() + $index + 1 }}
                                        </td>
                                        <td class="text-center">
                                            @if($feature->image)
                                                <img src="{{ $feature->image_url }}" 
                                                     alt="Feature image" 
                                                     class="img-thumbnail" 
                                                     style="max-width: 60px; max-height: 60px;">
                                            @else
                                                <span class="text-muted">Không có ảnh</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ $feature->getTranslation('title', 'vi') }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ $feature->getTranslation('title', 'en') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ Str::limit($feature->getTranslation('description', 'vi'), 50) }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ Str::limit($feature->getTranslation('description', 'en'), 50) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="order-badge">{{ $feature->sort_order }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge {{ $feature->is_active ? 'status-active' : 'status-inactive' }}">
                                                {{ $feature->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons-wrapper">
                                                <a href="{{ route('admin.features.edit', $feature) }}"
                                                    class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @include('components.delete-form', [
                                                    'id' => $feature->id,
                                                    'route' => route('admin.features.destroy', $feature),
                                                    'message' => "Bạn có chắc chắn muốn xóa Feature này?",
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
                            Hiển thị {{ $features->firstItem() ?? 0 }} đến {{ $features->lastItem() ?? 0 }} của
                            {{ $features->total() }} Features
                        </div>
                        <div class="pagination-controls">
                            {{ $features->links('components.paginate') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .order-badge {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
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
    </style>
@endpush 