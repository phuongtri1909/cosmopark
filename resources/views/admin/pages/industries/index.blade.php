@extends('admin.layouts.sidebar')

@section('title', 'Quản lý Ngành công nghiệp')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item current">Ngành công nghiệp</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-industry icon-title"></i>
                    <h5>Danh sách Ngành công nghiệp</h5>
                </div>
                <a href="{{ route('admin.industries.create') }}" class="action-button">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>

            <div class="card-content">
                @if ($industries->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-industry"></i>
                        </div>
                        <h4>Chưa có ngành công nghiệp nào</h4>
                        <p>Bắt đầu bằng cách thêm ngành công nghiệp đầu tiên.</p>
                        <a href="{{ route('admin.industries.create') }}" class="action-button">
                            <i class="fas fa-plus"></i> Thêm mới
                        </a>
                    </div>
                @else
                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="column-small">STT</th>
                                    <th class="column-small">Icon</th>
                                    <th class="column-medium">Tên ngành</th>
                                    <th class="column-medium">Mô tả</th>
                                    <th class="column-small">Thứ tự</th>
                                    <th class="column-small text-center">Trạng thái</th>
                                    <th class="column-small text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($industries as $index => $industry)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($industries->currentPage() - 1) * $industries->perPage() + $index + 1 }}
                                        </td>
                                        <td class="text-center">
                                            @if ($industry->icon)
                                                <img src="{{ asset('storage/' . $industry->icon) }}" 
                                                     alt="{{ $industry->getTranslation('name', 'vi') }}" 
                                                     class="industry-icon" width="40" height="40">
                                            @else
                                                <div class="industry-icon-placeholder">
                                                    <i class="fas fa-industry"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ $industry->getTranslation('name', 'vi') }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ $industry->getTranslation('name', 'en') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ Str::limit($industry->getTranslation('description', 'vi'), 50) }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ Str::limit($industry->getTranslation('description', 'en'), 50) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="order-badge">{{ $industry->sort_order }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge {{ $industry->is_active ? 'status-active' : 'status-inactive' }}">
                                                {{ $industry->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons-wrapper">
                                                <a href="{{ route('admin.industries.edit', $industry) }}"
                                                    class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @include('components.delete-form', [
                                                    'id' => $industry->id,
                                                    'route' => route('admin.industries.destroy', $industry),
                                                    'message' => "Bạn có chắc chắn muốn xóa ngành '{$industry->getTranslation('name', 'vi')}'?",
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
                            Hiển thị {{ $industries->firstItem() ?? 0 }} đến {{ $industries->lastItem() ?? 0 }} của
                            {{ $industries->total() }} ngành công nghiệp
                        </div>
                        <div class="pagination-controls">
                            {{ $industries->links('components.paginate') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .industry-icon {
            border-radius: 8px;
            object-fit: cover;
        }

        .industry-icon-placeholder {
            width: 40px;
            height: 40px;
            background: #f8f9fa;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6c757d;
            font-size: 18px;
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