@extends('admin.layouts.sidebar')

@section('title', 'Quản lý tính năng giới thiệu')

@section('main-content')
<div class="category-container">
    <!-- Breadcrumb -->
    <div class="content-breadcrumb">
        <ol class="breadcrumb-list">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item current">Tính Năng Giới Thiệu</li>
        </ol>
    </div>

    <div class="content-card">
        <div class="card-top">
            <div class="card-title">
                <i class="fas fa-chart-bar icon-title"></i>
                <h5>Danh sách tính năng giới thiệu</h5>
            </div>
            <a href="{{ route('admin.intro-features.create') }}" class="action-button">
                <i class="fas fa-plus"></i> Thêm tính năng
            </a>
        </div>
        
        <div class="card-content">
            @if($introFeatures->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h4>Chưa có tính năng giới thiệu nào</h4>
                    <p>Bắt đầu bằng cách thêm tính năng đầu tiên.</p>
                    <a href="{{ route('admin.intro-features.create') }}" class="action-button">
                        <i class="fas fa-plus"></i> Thêm tính năng mới
                    </a>
                </div>
            @else
                <div class="data-table-container">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th class="column-small">STT</th>
                                <th class="column-large">Tên tính năng</th>
                                <th class="column-medium">Giá trị</th>
                                <th class="column-small">Đơn vị</th>
                                <th class="column-small">Thứ tự</th>
                                <th class="column-small">Trạng thái</th>
                                <th class="column-small text-center">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($introFeatures as $index => $introFeature)
                                <tr>
                                    <td class="text-center">{{ ($introFeatures->currentPage() - 1) * $introFeatures->perPage() + $index + 1 }}</td>
                                    <td class="item-name">
                                        <div class="language-content">
                                            <strong>VI:</strong> {{ $introFeature->getTranslation('name', 'vi') }}<br>
                                            <strong>EN:</strong> {{ $introFeature->getTranslation('name', 'en') }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="language-content">
                                            <strong>VI:</strong> {{ $introFeature->getTranslation('value', 'vi') }}<br>
                                            <strong>EN:</strong> {{ $introFeature->getTranslation('value', 'en') }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="language-content">
                                            <strong>VI:</strong> {{ $introFeature->getTranslation('unit', 'vi') }}<br>
                                            <strong>EN:</strong> {{ $introFeature->getTranslation('unit', 'en') }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="order-badge">{{ $introFeature->sort_order }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if($introFeature->is_active)
                                            <span class="status-badge active">Hiển thị</span>
                                        @else
                                            <span class="status-badge inactive">Ẩn</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons-wrapper">
                                            <a href="{{ route('admin.intro-features.edit', $introFeature) }}" class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            @include('components.delete-form', [
                                                'id' => $introFeature->id,
                                                'route' => route('admin.intro-features.destroy', $introFeature),
                                                'message' => "Bạn có chắc chắn muốn xóa tính năng '{$introFeature->getTranslation('name', 'vi')}'?"
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
                        Hiển thị {{ $introFeatures->firstItem() ?? 0 }} đến {{ $introFeatures->lastItem() ?? 0 }} của {{ $introFeatures->total() }} tính năng
                    </div>
                    <div class="pagination-controls">
                        {{ $introFeatures->links('components.paginate') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 