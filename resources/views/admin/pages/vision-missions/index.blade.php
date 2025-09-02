@extends('admin.layouts.sidebar')

@section('title', 'Quản lý Tầm nhìn & Sứ mệnh')

@section('main-content')
    <div class="category-container">
        <!-- Breadcrumb -->
        <div class="content-breadcrumb">
            <ol class="breadcrumb-list">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item current">Tầm nhìn & Sứ mệnh</li>
            </ol>
        </div>

        <div class="content-card">
            <div class="card-top">
                <div class="card-title">
                    <i class="fas fa-eye icon-title"></i>
                    <h5>Danh sách Tầm nhìn & Sứ mệnh</h5>
                </div>
                <a href="{{ route('admin.vision-missions.create') }}" class="action-button">
                    <i class="fas fa-plus"></i> Thêm mới
                </a>
            </div>

            <div class="card-content">
                @if ($visionMissions->isEmpty())
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h4>Chưa có Tầm nhìn & Sứ mệnh nào</h4>
                        <p>Bắt đầu bằng cách thêm Tầm nhìn & Sứ mệnh đầu tiên.</p>
                        <a href="{{ route('admin.vision-missions.create') }}" class="action-button">
                            <i class="fas fa-plus"></i> Thêm mới
                        </a>
                    </div>
                @else
                    <div class="data-table-container">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th class="column-small">STT</th>
                                    <th class="column-small">Loại</th>
                                    <th class="column-medium">Tiêu đề</th>
                                    <th class="column-medium">Mô tả</th>
                                    <th class="column-small">Thứ tự</th>
                                    <th class="column-small text-center">Trạng thái</th>
                                    <th class="column-small text-center">Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($visionMissions as $index => $visionMission)
                                    <tr>
                                        <td class="text-center">
                                            {{ ($visionMissions->currentPage() - 1) * $visionMissions->perPage() + $index + 1 }}
                                        </td>
                                        <td class="text-center">
                                            <span class="type-badge {{ $visionMission->type === 'vision' ? 'type-vision' : 'type-mission' }}">
                                                {{ $visionMission->type === 'vision' ? 'Tầm nhìn' : 'Sứ mệnh' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ $visionMission->getTranslation('title', 'vi') }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ $visionMission->getTranslation('title', 'en') }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="multi-lang-content">
                                                <div class="lang-item">
                                                    <span class="lang-label">VI:</span>
                                                    <span class="lang-text">{{ Str::limit($visionMission->getTranslation('description', 'vi'), 50) }}</span>
                                                </div>
                                                <div class="lang-item">
                                                    <span class="lang-label">EN:</span>
                                                    <span class="lang-text">{{ Str::limit($visionMission->getTranslation('description', 'en'), 50) }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <span class="order-badge">{{ $visionMission->sort_order }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="status-badge {{ $visionMission->is_active ? 'status-active' : 'status-inactive' }}">
                                                {{ $visionMission->is_active ? 'Đang hiển thị' : 'Đã ẩn' }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons-wrapper">
                                                <a href="{{ route('admin.vision-missions.edit', $visionMission) }}"
                                                    class="action-icon edit-icon text-decoration-none" title="Chỉnh sửa">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @include('components.delete-form', [
                                                    'id' => $visionMission->id,
                                                    'route' => route('admin.vision-missions.destroy', $visionMission),
                                                    'message' => "Bạn có chắc chắn muốn xóa {{ $visionMission->type === 'vision' ? 'Tầm nhìn' : 'Sứ mệnh' }} này?",
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
                            Hiển thị {{ $visionMissions->firstItem() ?? 0 }} đến {{ $visionMissions->lastItem() ?? 0 }} của
                            {{ $visionMissions->total() }} Tầm nhìn & Sứ mệnh
                        </div>
                        <div class="pagination-controls">
                            {{ $visionMissions->links('components.paginate') }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .type-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .type-vision {
            background: #e3f2fd;
            color: #1976d2;
        }

        .type-mission {
            background: #f3e5f5;
            color: #7b1fa2;
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