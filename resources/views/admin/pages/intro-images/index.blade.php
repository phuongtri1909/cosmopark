@extends('admin.layouts.sidebar')

@section('title', 'Quản lý ảnh giới thiệu')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item current">Ảnh giới thiệu</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-image icon-title"></i>
                    <h5>Danh sách ảnh giới thiệu</h5>
                <small class="text-muted">(Dùng chung cho trang chủ và trang về chúng tôi)</small>
                </div>
                <a href="{{ route('admin.intro-images.create') }}" class="action-button">
                    <i class="fas fa-plus"></i> Thêm ảnh giới thiệu
                </a>
            </div>

            <div class="card-content">
                @if ($introImages->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <h4>Chưa có ảnh giới thiệu nào</h4>
                        <p>Bắt đầu bằng cách thêm ảnh giới thiệu đầu tiên.</p>
                        <a href="{{ route('admin.intro-images.create') }}" class="action-button">
                            <i class="fas fa-plus"></i> Thêm ảnh giới thiệu mới
                        </a>
                    </div>
                @else
                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="column-small">STT</th>
                                    <th class="column-medium">Ảnh</th>
                                    <th class="column-medium">Tiêu đề</th>
                                    <th class="column-medium">Mô tả</th>
                                    <th class="column-small">Thứ tự</th>
                                    <th class="column-small text-center">Trạng thái</th>
                                    <th class="column-small text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($introImages as $index => $introImage)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($introImages->currentPage() - 1) * $introImages->perPage() + $index + 1 }}
                                        </td>
                                        <td class="intro-image-image">
                                            @if($introImage->image)
                                                <img src="{{ asset('storage/' . $introImage->image) }}" 
                                                     alt="Ảnh giới thiệu" 
                                                     class="thumbnail">
                                            @else
                                                <span class="text-muted">Không có ảnh</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ $introImage->getTranslation('title', 'vi') }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ $introImage->getTranslation('title', 'en') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ Str::limit($introImage->getTranslation('description', 'vi'), 50) }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ Str::limit($introImage->getTranslation('description', 'en'), 50) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="order-badge">{{ $introImage->sort_order }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge {{ $introImage->is_active ? 'status-active' : 'status-inactive' }}">
                                                {{ $introImage->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons-wrapper">
                                                <a href="{{ route('admin.intro-images.edit', $introImage) }}"
                                                    class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @include('components.delete-form', [
                                                    'id' => $introImage->id,
                                                    'route' => route('admin.intro-images.destroy', $introImage),
                                                    'message' => "Bạn có chắc chắn muốn xóa ảnh giới thiệu này?",
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
                            Hiển thị {{ $introImages->firstItem() ?? 0 }} đến {{ $introImages->lastItem() ?? 0 }} của
                            {{ $introImages->total() }} ảnh giới thiệu
                        </div>
                        <div class="pagination-controls">
                            {{ $introImages->links('components.paginate') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .intro-image-image img {
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