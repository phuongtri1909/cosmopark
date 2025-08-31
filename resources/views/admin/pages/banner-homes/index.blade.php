@extends('admin.layouts.sidebar')

@section('title', 'Quản lý banner trang chủ')

@section('main-content')
<div class="category-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item current">Banner Trang Chủ</li>
        </ol>
    </div>

    <div class="content-card">
        <div class="card-top">
            <div class="card-title">
                <i class="fas fa-home icon-title"></i>
                <h5>Danh sách banner trang chủ</h5>
            </div>
            <a href="{{ route('admin.banner-homes.create') }}" class="action-button">
                <i class="fas fa-plus"></i> Thêm banner
            </a>
        </div>
        
        <div class="card-content">
            @if($bannerHomes->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <h4>Chưa có banner trang chủ nào</h4>
                    <p>Bắt đầu bằng cách thêm banner đầu tiên cho trang chủ.</p>
                    <a href="{{ route('admin.banner-homes.create') }}" class="action-button">
                        <i class="fas fa-plus"></i> Thêm banner mới
                    </a>
                </div>
            @else
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="column-small">STT</th>
                                <th class="column-medium">Hình ảnh</th>
                                <th class="column-small">Thứ tự</th>
                                <th class="column-small">Trạng thái</th>
                                <th class="column-small text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bannerHomes as $index => $bannerHome)
                                <tr>
                                    <td class="text-center">{{ ($bannerHomes->currentPage() - 1) * $bannerHomes->perPage() + $index + 1 }}</td>
                                    <td>
                                        <img src="{{ $bannerHome->image_url }}" alt="Banner trang chủ" class="thumbnail-image" style="max-width: 100px; max-height: 60px;">
                                    </td>
                                    <td class="text-center">
                                        <span class="order-badge">{{ $bannerHome->sort_order }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($bannerHome->is_active)
                                            <span class="status-badge active">Hiển thị</span>
                                        @else
                                            <span class="status-badge inactive">Ẩn</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons-wrapper">
                                            <a href="{{ route('admin.banner-homes.edit', $bannerHome) }}" class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @include('components.delete-form', [
                                                'id' => $bannerHome->id,
                                                'route' => route('admin.banner-homes.destroy', $bannerHome),
                                                'message' => "Bạn có chắc chắn muốn xóa banner trang chủ này?"
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
                        Hiển thị {{ $bannerHomes->firstItem() ?? 0 }} đến {{ $bannerHomes->lastItem() ?? 0 }} của {{ $bannerHomes->total() }} banner
                    </div>
                    <div class="pagination-controls">
                        {{ $bannerHomes->links('components.paginate') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 