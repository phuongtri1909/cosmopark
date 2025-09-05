@extends('admin.layouts.sidebar')

@section('title', 'Quản lý slide vị trí')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item current">Slide vị trí</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-images icon-title"></i>
                    <h5>Danh sách slide vị trí</h5>
                <small class="text-muted">(Dùng chung cho trang chủ và trang về chúng tôi)</small>
                </div>
                <a href="{{ route('admin.slide-locations.create') }}" class="action-button">
                    <i class="fas fa-plus"></i> Thêm slide vị trí
                </a>
            </div>

            <div class="card-content">
                @if ($slideLocations->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-images"></i>
                        </div>
                        <h4>Chưa có slide vị trí nào</h4>
                        <p>Bắt đầu bằng cách thêm slide vị trí đầu tiên.</p>
                        <a href="{{ route('admin.slide-locations.create') }}" class="action-button">
                            <i class="fas fa-plus"></i> Thêm slide vị trí mới
                        </a>
                    </div>
                @else
                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="column-small">STT</th>
                                    <th class="column-medium">Ảnh</th>
                                    <th class="column-small">Thứ tự</th>
                                    <th class="column-small text-center">Trạng thái</th>
                                    <th class="column-small text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($slideLocations as $index => $slideLocation)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($slideLocations->currentPage() - 1) * $slideLocations->perPage() + $index + 1 }}
                                        </td>
                                        <td class="slide-location-image">
                                            @if($slideLocation->image)
                                                <img src="{{ asset('storage/' . $slideLocation->image) }}" 
                                                     alt="Ảnh slide" 
                                                     class="thumbnail">
                                            @else
                                                <span class="text-muted">Không có ảnh</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <span class="order-badge">{{ $slideLocation->sort_order }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge {{ $slideLocation->is_active ? 'status-active' : 'status-inactive' }}">
                                                {{ $slideLocation->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons-wrapper">
                                                <a href="{{ route('admin.slide-locations.edit', $slideLocation) }}"
                                                    class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @include('components.delete-form', [
                                                    'id' => $slideLocation->id,
                                                    'route' => route('admin.slide-locations.destroy', $slideLocation),
                                                    'message' => "Bạn có chắc chắn muốn xóa slide vị trí này?",
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
                            Hiển thị {{ $slideLocations->firstItem() ?? 0 }} đến {{ $slideLocations->lastItem() ?? 0 }} của
                            {{ $slideLocations->total() }} slide vị trí
                        </div>
                        <div class="pagination-controls">
                            {{ $slideLocations->links('components.paginate') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .slide-location-image img {
            width: 80px;
            height: 60px;
            object-fit: cover;
            border-radius: 4px;
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