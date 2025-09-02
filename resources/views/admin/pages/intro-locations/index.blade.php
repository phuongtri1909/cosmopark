@extends('admin.layouts.sidebar')

@section('title', 'Quản lý thông tin vị trí')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item current">Thông tin vị trí</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-map-marker-alt icon-title"></i>
                    <h5>Danh sách thông tin vị trí</h5>
                </div>
                <a href="{{ route('admin.intro-locations.create') }}" class="action-button">
                    <i class="fas fa-plus"></i> Thêm thông tin vị trí
                </a>
            </div>

            <div class="card-content">
                @if ($introLocations->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h4>Chưa có thông tin vị trí nào</h4>
                        <p>Bắt đầu bằng cách thêm thông tin vị trí đầu tiên.</p>
                        <a href="{{ route('admin.intro-locations.create') }}" class="action-button">
                            <i class="fas fa-plus"></i> Thêm thông tin vị trí mới
                        </a>
                    </div>
                @else
                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="column-small">STT</th>
                                    <th class="column-small">Ảnh</th>
                                    <th class="column-large">Tiêu đề</th>
                                    <th class="column-medium">Mô tả</th>
                                    <th class="column-small">Số thống kê</th>
                                    <th class="column-small">Thứ tự</th>
                                    <th class="column-small text-center">Trạng thái</th>
                                    <th class="column-small text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($introLocations as $index => $introLocation)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($introLocations->currentPage() - 1) * $introLocations->perPage() + $index + 1 }}
                                        </td>
                                        <td class="intro-location-image">
                                            @if($introLocation->image)
                                                <img src="{{ asset('storage/' . $introLocation->image) }}" 
                                                     alt="Ảnh vị trí" 
                                                     class="thumbnail">
                                            @else
                                                <span class="text-muted">Không có ảnh</span>
                                            @endif
                                        </td>
                                        <td class="item-title">
                                            <div class="language-content">
                                                <strong>VI:</strong> {{ $introLocation->getTranslation('title', 'vi') }}<br>
                                                <strong>EN:</strong> {{ $introLocation->getTranslation('title', 'en') }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="language-content">
                                                <strong>VI:</strong> {{ Str::limit($introLocation->getTranslation('description', 'vi'), 80) }}<br>
                                                <strong>EN:</strong> {{ Str::limit($introLocation->getTranslation('description', 'en'), 80) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-info">{{ $introLocation->stats()->count() }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="order-badge">{{ $introLocation->sort_order }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge {{ $introLocation->is_active ? 'status-active' : 'status-inactive' }}">
                                                {{ $introLocation->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons-wrapper">
                                                <a href="{{ route('admin.intro-locations.edit', $introLocation) }}"
                                                    class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @include('components.delete-form', [
                                                    'id' => $introLocation->id,
                                                    'route' => route('admin.intro-locations.destroy', $introLocation),
                                                    'message' => "Bạn có chắc chắn muốn xóa thông tin vị trí '{$introLocation->getTranslation('title', 'vi')}'?",
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
                            Hiển thị {{ $introLocations->firstItem() ?? 0 }} đến {{ $introLocations->lastItem() ?? 0 }} của
                            {{ $introLocations->total() }} thông tin vị trí
                        </div>
                        <div class="pagination-controls">
                            {{ $introLocations->links('components.paginate') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .intro-location-image img {
            width: 60px;
            height: 40px;
            object-fit: cover;
            border-radius: 4px;
        }

        .language-content {
            font-size: 0.9em;
            line-height: 1.4;
        }

        .language-content strong {
            color: #6c757d;
            font-size: 0.8em;
        }

        .order-badge {
            display: inline-block;
            background: #e3f2fd;
            color: #1976d2;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 12px;
        }
    </style>
@endpush 