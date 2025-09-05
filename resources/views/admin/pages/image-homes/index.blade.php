@extends('admin.layouts.sidebar')

@section('title', 'Quản lý hình ảnh')

@section('main-content')
<div class="category-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item current">Hình Ảnh</li>
        </ol>
    </div>

    <div class="content-card">
        <div class="card-top">
            <div class="card-title">
                <i class="fas fa-images icon-title"></i>
                <h5>Danh sách hình ảnh</h5>
                <small class="text-muted">(Dùng chung cho trang chủ và trang về chúng tôi)</small>
            </div>
            <a href="{{ route('admin.image-homes.create') }}" class="action-button">
                <i class="fas fa-plus"></i> Thêm hình ảnh
            </a>
        </div>
        
        <div class="card-content">
            @if($imageHomes->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <h4>Chưa có hình ảnh nào</h4>
                    <p>Bắt đầu bằng cách thêm hình ảnh đầu tiên.</p>
                    <a href="{{ route('admin.image-homes.create') }}" class="action-button">
                        <i class="fas fa-plus"></i> Thêm hình ảnh mới
                    </a>
                </div>
            @else
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="column-small">STT</th>
                                <th class="column-medium">Hình ảnh chính</th>
                                <th class="column-large">Tiêu đề</th>
                                <th class="column-small">Hình phụ</th>
                                <th class="column-small">Thứ tự</th>
                                <th class="column-small">Trạng thái</th>
                                <th class="column-small text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($imageHomes as $index => $imageHome)
                                <tr>
                                    <td class="text-center">{{ ($imageHomes->currentPage() - 1) * $imageHomes->perPage() + $index + 1 }}</td>
                                    <td>
                                        <img src="{{ $imageHome->main_image_url }}" alt="Hình ảnh chính" class="thumbnail-image" style="max-width: 100px; max-height: 60px;">
                                    </td>
                                    <td>
                                        <div class="title-cell">
                                            <span class="title-text">{{ $imageHome->title }}</span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="sub-count-badge">{{ $imageHome->subImages->count() }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="order-badge">{{ $imageHome->sort_order }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($imageHome->is_active)
                                            <span class="status-badge active">Hiển thị</span>
                                        @else
                                            <span class="status-badge inactive">Ẩn</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons-wrapper">
                                            <a href="{{ route('admin.image-homes.edit', $imageHome) }}" class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @include('components.delete-form', [
                                                'id' => $imageHome->id,
                                                'route' => route('admin.image-homes.destroy', $imageHome),
                                                'message' => "Bạn có chắc chắn muốn xóa hình ảnh trang chủ này?"
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
                        Hiển thị {{ $imageHomes->firstItem() ?? 0 }} đến {{ $imageHomes->lastItem() ?? 0 }} của {{ $imageHomes->total() }} hình ảnh
                    </div>
                    <div class="pagination-controls">
                        {{ $imageHomes->links('components.paginate') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.title-cell {
    max-width: 300px;
}

.title-text {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.sub-count-badge {
    background: #17a2b8;
    color: white;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 12px;
    font-weight: 500;
}

.thumbnail-image {
    border-radius: 4px;
    object-fit: cover;
}
</style>
@endsection 