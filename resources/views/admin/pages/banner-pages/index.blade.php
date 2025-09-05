@extends('admin.layouts.sidebar')

@section('title', 'Quản lý Banner Trang')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item current">Banner Trang</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-image icon-title"></i>
                    <h5>Danh sách Banner Trang
                        @if($currentPage)
                            - {{ ucfirst($currentPage) }}
                        @endif
                    </h5>
                </div>
                <a href="{{ route('admin.banner-pages.create', ['page' => $currentPage]) }}" class="action-button">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>

            <div class="card-content">
                @if ($bannerPages->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-image"></i>
                        </div>
                        <h4>Chưa có banner trang nào</h4>
                        <p>Bắt đầu bằng cách thêm banner trang đầu tiên.</p>
                        <a href="{{ route('admin.banner-pages.create', ['page' => $currentPage]) }}" class="action-button">
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
                                    <th class="column-small">Key</th>
                                    <th class="column-small text-center">Trạng thái</th>
                                    <th class="column-small text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bannerPages as $index => $bannerPage)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($bannerPages->currentPage() - 1) * $bannerPages->perPage() + $index + 1 }}
                                        </td>
                                        <td class="text-center">
                                            @if ($bannerPage->image)
                                                <img src="{{ asset('storage/' . $bannerPage->image) }}" 
                                                     alt="{{ $bannerPage->getTranslation('title', 'vi') }}" 
                                                     class="banner-image" width="50" height="50">
                                            @else
                                                <div class="banner-image-placeholder">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ $bannerPage->getTranslation('title', 'vi') }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ $bannerPage->getTranslation('title', 'en') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <code class="key-text">{{ $bannerPage->key }}</code>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge {{ $bannerPage->is_active ? 'status-active' : 'status-inactive' }}">
                                                {{ $bannerPage->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons-wrapper">
                                                <a href="{{ route('admin.banner-pages.edit', ['banner_page' => $bannerPage, 'page' => $currentPage]) }}"
                                                    class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @include('components.delete-form', [
                                                    'id' => $bannerPage->id,
                                                    'route' => route('admin.banner-pages.destroy', ['banner_page' => $bannerPage, 'page' => $currentPage]),
                                                    'message' => "Bạn có chắc chắn muốn xóa banner trang '{$bannerPage->getTranslation('title', 'vi')}'?",
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
                            Hiển thị {{ $bannerPages->firstItem() ?? 0 }} đến {{ $bannerPages->lastItem() ?? 0 }} của
                            {{ $bannerPages->total() }} banner trang
                        </div>
                        <div class="pagination-controls">
                            {{ $bannerPages->links('components.paginate') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .banner-image {
            border-radius: 8px;
            object-fit: cover;
        }

        .banner-image-placeholder {
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

        .key-text {
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
    </style>
@endpush