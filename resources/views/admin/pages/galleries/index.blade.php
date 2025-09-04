@extends('admin.layouts.sidebar')

@section('title', 'Quản lý Gallery')

@section('main-content')
<div class="category-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item current">Gallery</li>
        </ol>
    </div>

    <div class="content-card">
        <div class="card-top">
            <div class="card-title">
                <i class="fas fa-images icon-title"></i>
                <h5>Danh sách Gallery</h5>
            </div>
            <a href="{{ route('admin.galleries.create') }}" class="action-button">
                <i class="fas fa-plus"></i> Thêm Gallery
            </a>
        </div>
        
        <div class="card-content">
            @if($galleries->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-images"></i>
                    </div>
                    <h4>Chưa có Gallery nào</h4>
                    <p>Bắt đầu bằng cách thêm Gallery đầu tiên.</p>
                    <a href="{{ route('admin.galleries.create') }}" class="action-button">
                        <i class="fas fa-plus"></i> Thêm Gallery mới
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
                                <th class="column-medium">Dự án</th>
                                <th class="column-small">Số ảnh</th>
                                <th class="column-small">Thứ tự</th>
                                <th class="column-small">Trạng thái</th>
                                <th class="column-small text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($galleries as $index => $gallery)
                                <tr>
                                    <td class="text-center">{{ ($galleries->currentPage() - 1) * $galleries->perPage() + $index + 1 }}</td>
                                    <td>
                                        <img src="{{ $gallery->main_image_url }}" alt="Hình ảnh chính" class="thumbnail-image" style="max-width: 100px; max-height: 60px;">
                                    </td>
                                    <td>
                                        <div class="title-cell">
                                            <span class="title-text">{{ $gallery->title }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="project-cell">
                                            <span class="project-text">
                                                {{ $gallery->project ? $gallery->project->getTranslation('title', app()->getLocale()) : 'Chưa chọn dự án' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="image-count-badge">{{ count($gallery->all_images) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="order-badge">{{ $gallery->sort_order }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($gallery->is_active)
                                            <span class="status-badge active">Hiển thị</span>
                                        @else
                                            <span class="status-badge inactive">Ẩn</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons-wrapper">
                                            <a href="{{ route('admin.galleries.edit', $gallery) }}" class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @include('components.delete-form', [
                                                'id' => $gallery->id,
                                                'route' => route('admin.galleries.destroy', $gallery),
                                                'message' => "Bạn có chắc chắn muốn xóa Gallery này?"
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
                        Hiển thị {{ $galleries->firstItem() ?? 0 }} đến {{ $galleries->lastItem() ?? 0 }} của {{ $galleries->total() }} Gallery
                    </div>
                    <div class="pagination-controls">
                        {{ $galleries->links('components.paginate') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.title-cell, .project-cell {
    max-width: 300px;
}

.title-text, .project-text {
    display: block;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.image-count-badge {
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